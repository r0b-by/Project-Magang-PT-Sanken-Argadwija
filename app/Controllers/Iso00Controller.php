<?php

namespace App\Controllers;

use App\Models\Iso00Model;
use App\Models\Iso001Model;
use App\Models\UserModel;
use App\Models\DepartmentModel;
use App\Models\IsoAccessHolderModel;
use App\Models\IsoAccessUserModel;

class Iso00Controller extends BaseController
{
    protected $iso00;
    protected $iso001;
    protected $user;
    protected $department;
    protected $holder;
    protected $accessUser;
    protected $masterPath;
    protected $revisionPath;

    public function __construct()
    {
        $this->iso00        = new Iso00Model();
        $this->iso001       = new Iso001Model();
        $this->user         = new UserModel();
        $this->department   = new DepartmentModel();
        $this->holder       = new IsoAccessHolderModel();
        $this->accessUser   = new IsoAccessUserModel();
        $this->masterPath   = WRITEPATH . 'uploads/iso/masters/';
        $this->revisionPath = WRITEPATH . 'uploads/iso/revisions/';
    }

    private function currentUser(): array
    {
        return [
            'id'   => session()->get('user_id'),
            'name' => session()->get('fullname') ?? 'Administrator Sistem',
            'role' => session()->get('role') ?? 'admin',
            'foto' => session()->get('foto') ?? 'default.png',
        ];
    }

    // ============================================================
    // HAK AKSES USER
    // ============================================================
    private function checkAccess($docId)
    {
        $role   = session()->get('role');
        $userId = session()->get('user_id');

        if ($role === 'admin') return true;

        return $this->accessUser
            ->join('iso_access_documents', 'iso_access_documents.holder_id = iso_access_users.holder_id')
            ->where('iso_access_users.user_id', $userId)
            ->where('iso_access_documents.iso00_id', $docId)
            ->countAllResults() > 0;
    }

    private function sanitizeFileName(string $filename): string
    {
        $name = pathinfo($filename, PATHINFO_FILENAME);
        $name = preg_replace('/[^a-zA-Z0-9-_]/', '_', $name);
        return strtolower($name);
    }

    private function generateSafeFileName($file, $path)
    {
        $original = $file->getClientName();
        $ext      = $file->getClientExtension();
        $safe     = $this->sanitizeFileName($original);

        $final = $safe . '.' . $ext;
        $i = 1;

        while (file_exists($path . $final)) {
            $final = $safe . '_' . $i . '.' . $ext;
            $i++;
        }

        return $final;
    }

    // ============================================================
    // INDEX / LIST DOKUMEN
    // ============================================================
    public function index()
    {
        $role   = session()->get('role');
        $userId = session()->get('user_id');

        $baseQuery = $this->iso00
            ->select('
                iso_00.*,
                uploader.fullname AS uploader_name,
                uploader.role     AS uploader_role,
                uploader.foto     AS uploader_foto,
                updater.fullname AS updater_name,
                updater.role     AS updater_role,
                updater.foto     AS updater_foto,
                departments.nama_dept AS department_name,
                departments.kode_dept AS department_code
            ')
            ->join('users AS uploader', 'uploader.id = iso_00.uploaded_by', 'left')
            ->join('users AS updater', 'updater.id = iso_00.updated_by', 'left')
            ->join('departments', 'departments.id = iso_00.department_id', 'left');

        if ($role === 'admin') {
            $dokumen = $baseQuery->orderBy('iso_00.id', 'DESC')->findAll();
        } else {
            $allowedDocs = $this->accessUser
                ->select('iso_access_documents.iso00_id')
                ->join('iso_access_documents', 'iso_access_documents.holder_id = iso_access_users.holder_id')
                ->where('iso_access_users.user_id', $userId)
                ->findAll();
            $docIds = array_column($allowedDocs, 'iso00_id');

            $dokumen = empty($docIds)
                ? []
                : $baseQuery->whereIn('iso_00.id', $docIds)->orderBy('iso_00.id', 'DESC')->findAll();
        }

        // Tambahkan holder & user
        foreach ($dokumen as &$doc) {
            $holders = $this->holder->getHolderWithUsersByDokumen($doc['id']);
            $doc['holder_code']  = $holders[0]['holder_code'] ?? null;
            $doc['holder_users'] = array_column(array_filter($holders, fn($h) => !empty($h['fullname'])), 'fullname');
        }

        $departments = $this->department->select('id,kode_dept,nama_dept')->orderBy('kode_dept','ASC')->findAll();

        return view('iso00/index', [
            'dokumen'     => $dokumen,
            'departments' => $departments
        ]);
    }

    // ============================================================
    // CREATE / STORE
    // ============================================================
    public function create()
    {
        $departments = $this->department
            ->select('id,kode_dept,nama_dept')
            ->where('status', 'active')
            ->orderBy('kode_dept', 'ASC')
            ->findAll();

        return view('iso00/create', [
            'departments' => $departments
        ]);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'kode_dokumen'          => 'required|alpha_numeric_punct|max_length[50]',
            'nama_dokumen_internal' => 'required|string|max_length[255]',
            'department_id'         => 'required|integer|is_not_unique[departments.id]',
            'upload_dokumen'        => 'uploaded[upload_dokumen]|max_size[upload_dokumen,10240]|ext_in[upload_dokumen,pdf]',
        ], [
            'kode_dokumen' => [
                'required' => 'Kode dokumen wajib diisi.',
            ],
            'nama_dokumen_internal' => [
                'required' => 'Nama dokumen internal wajib diisi.',
            ],
            'department_id' => [
                'required' => 'Departemen wajib dipilih.',
                'is_not_unique' => 'Departemen tidak valid.'
            ],
            'upload_dokumen' => [
                'uploaded' => 'File wajib diunggah.',
                'max_size' => 'Ukuran file maksimal 10MB.',
                'ext_in'  => 'Format file harus PDF.'
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return back()->withInput()->with('errors', $validation->getErrors());
        }

        $file = $this->request->getFile('upload_dokumen');
        $user = $this->currentUser();

        // pastikan folder master tersedia
        if (!is_dir($this->masterPath)) mkdir($this->masterPath, 0775, true);

        // generate nama file aman
        $finalName = $this->generateSafeFileName($file, $this->masterPath);
        $file->move($this->masterPath, $finalName);

        $this->iso00->insert([
            'kode_dokumen'          => $this->request->getPost('kode_dokumen'),
            'nama_dokumen_internal' => $this->request->getPost('nama_dokumen_internal'),
            'nama_file'             => $finalName,
            'file_path'             => 'uploads/iso/masters/' . $finalName,
            'file_size'             => $file->getSize(),
            'mime_type'             => $file->getClientMimeType(),
            'tanggal_efektif'       => $this->request->getPost('tanggal_efektif') ?: null,
            'halaman_dokumen'       => $this->request->getPost('halaman_dokumen'),
            'ruang_lingkup'         => $this->request->getPost('ruang_lingkup'),
            'tujuan'                => $this->request->getPost('tujuan'),
            'department_id'         => $this->request->getPost('department_id'),
            'status'                => 'unsave',
            'revision_no'           => 0,
            'is_locked'             => 1,
            'uploaded_by'           => $user['id'],
            'uploaded_at'           => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/iso00')
                        ->with('success', 'Dokumen berhasil diunggah dan berstatus DRAFT (Unsave). Silakan lakukan pengecekan & simpan.');
    }

    /// ============================================================
// EDIT & UPDATE DOKUMEN MASTER + REVISI
// ============================================================
public function edit($id)
{
    // Ambil dokumen + info departemen
    $dokumen = $this->iso00
        ->select('iso_00.*, departments.id AS department_id, departments.kode_dept, departments.nama_dept')
        ->join('departments', 'departments.id = iso_00.department_id', 'left')
        ->where('iso_00.id', $id)
        ->first();

    if (!$dokumen) {
        return redirect()->to('/iso00')->with('error', 'Dokumen tidak ditemukan!');
    }

    // Cek akses
    $userId = session()->get('user_id');
    $role   = session()->get('role');
    if ($role !== 'admin' && $dokumen['uploaded_by'] != $userId) {
        return redirect()->to('/iso00')->with('error', 'Anda tidak memiliki akses mengedit dokumen ini!');
    }

    // Ambil semua departemen untuk select dropdown
    $departments = model('DepartmentModel')->findAll();

    // Nomor revisi selanjutnya
    $dokumen['next_revision'] = $dokumen['revision_no'] + 1;

    return view('iso00/edit', [
        'dokumen'     => $dokumen,
        'departments' => $departments
    ]);
}

public function update($id)
{
    $master = $this->iso00->find($id);
    if (!$master) {
        return redirect()->back()->with('error', 'Dokumen tidak ditemukan');
    }

    // Cek akses
    $userId = session()->get('user_id');
    $role   = session()->get('role');
    if ($role !== 'admin' && $master['uploaded_by'] != $userId) {
        return redirect()->to('/iso00')->with('error', 'Anda tidak memiliki akses!');
    }

    $validation = \Config\Services::validation();
$validation->setRules([
    'kode_dokumen'          => 'required|alpha_numeric_punct|max_length[50]',
    'nama_dokumen_internal' => 'required|string|max_length[255]',
    'tanggal_efektif'       => 'permit_empty|valid_date[Y-m-d]',
    'halaman_dokumen' => 'permit_empty|string|max_length[50]',
    'ruang_lingkup'         => 'permit_empty|string|max_length[500]',
    'tujuan'                => 'permit_empty|string|max_length[500]',
    // File opsional
    'upload_dokumen'        => 'permit_empty|uploaded[upload_dokumen]|max_size[upload_dokumen,10240]|ext_in[upload_dokumen,pdf]'
]);

if (!$validation->withRequest($this->request)->run()) {
    // Tangkap error
    $errors = $validation->getErrors();

    // Bisa ditampilkan langsung di view atau via flashdata
    return redirect()->back()->withInput()->with('errors', $errors);
}


    $user    = $this->currentUser();
    $oldFile = WRITEPATH . $master['file_path'];

    /* =========================================================
     * 1. SIMPAN SNAPSHOT KE ISO_001 (HISTORY)
     * =======================================================*/
    $this->iso001->addRevision($master, [
        'revision_no'   => $master['revision_no'] + 1,
        'revision_note' => $this->request->getPost('catatan_revisi')
    ]);

    /* =========================================================
     * 2. DATA UPDATE METADATA MASTER
     * =======================================================*/
    $update = [
        'kode_dokumen'          => $this->request->getPost('kode_dokumen'),
        'nama_dokumen_internal' => $this->request->getPost('nama_dokumen_internal'),
        'tanggal_efektif'       => $this->request->getPost('tanggal_efektif') ?: null,
        'halaman_dokumen'       => $this->request->getPost('halaman_dokumen'),
        'ruang_lingkup'         => $this->request->getPost('ruang_lingkup'),
        'tujuan'                => $this->request->getPost('tujuan'),
        'department_id'         => $this->request->getPost('department_id'),
        'status'                => 'revisi',
        'revision_no'           => $master['revision_no'] + 1,
        'updated_by'            => $user['id'],
        'updated_at'            => date('Y-m-d H:i:s'),
    ];

    /* =========================================================
 * 3. HANDLE FILE BARU
 * =======================================================*/
$file = $this->request->getFile('upload_dokumen');
if ($file && $file->isValid() && !$file->hasMoved()) {
    // pastikan folder master & revisions ada
    if (!is_dir($this->masterPath)) mkdir($this->masterPath, 0775, true);
    if (!is_dir($this->revisionPath)) mkdir($this->revisionPath, 0775, true);

    // backup file lama ke revisions
    if (!empty($master['file_path']) && is_file($oldFile)) {
        $revisionName = pathinfo($master['nama_file'], PATHINFO_FILENAME)
                        . '_rev' . ($master['revision_no'] + 1) . '.'
                        . pathinfo($master['nama_file'], PATHINFO_EXTENSION);
        copy($oldFile, $this->revisionPath . $revisionName);
    }

    // simpan file baru ke master
    $newName = $this->generateSafeFileName($file, $this->masterPath);
    $file->move($this->masterPath, $newName);

    // update data master
    $update['nama_file'] = $newName;
    $update['file_path'] = 'uploads/iso/masters/' . $newName;
    $update['file_size'] = $file->getSize();
    $update['mime_type'] = $file->getClientMimeType();
}

    /* =========================================================
     * 4. EKSEKUSI UPDATE MASTER
     * =======================================================*/
    $this->iso00->update($id, $update);

    return redirect()->to('/iso00')
        ->with('success', 'Dokumen berhasil direvisi dan disimpan.');
}

    // ============================================================
    // SHOW
    // ============================================================
    public function show($id)
    {
        if (!$this->checkAccess($id)) return redirect()->to('/iso00')->with('error', 'Anda tidak memiliki akses!');

        $dokumen = $this->iso00
            ->select('
                iso_00.*,
                uploader.fullname AS uploader_name,
                uploader.role     AS uploader_role,
                updater.fullname AS updater_name,
                updater.role     AS updater_role,
                departments.kode_dept,
                departments.nama_dept
            ')
            ->join('users AS uploader', 'uploader.id = iso_00.uploaded_by', 'left')
            ->join('users AS updater', 'updater.id = iso_00.updated_by', 'left')
            ->join('departments', 'departments.id = iso_00.department_id', 'left')
            ->where('iso_00.id', $id)
            ->first();

        if (!$dokumen) return redirect()->to('/iso00')->with('error', 'Dokumen tidak ditemukan!');

        $statusMap = [
            'unsave' => ['label'=>'UNSAVE','badge'=>'secondary','icon'=>'lock'],
            'save'   => ['label'=>'SAVE','badge'=>'success','icon'=>'check-circle'],
            'revisi' => ['label'=>'REVISI','badge'=>'warning','icon'=>'pen'],
        ];

        $statusInfo = $statusMap[$dokumen['status']] ?? ['label'=>strtoupper($dokumen['status']),'badge'=>'dark','icon'=>'question'];

        $userId = session()->get('user_id');
        $role   = session()->get('role');

        $canManage = ($userId == $dokumen['uploaded_by'] || $role === 'admin');

        return view('iso00/show', [
            'dokumen'       => $dokumen,
            'statusLabel'   => $statusInfo['label'],
            'statusBadge'   => $statusInfo['badge'],
            'statusIcon'    => $statusInfo['icon'],
            'canManage'     => $canManage,
            'canEdit'       => $canManage && $dokumen['status'] !== 'unsave',
            'canSave'       => $canManage && $dokumen['status'] === 'unsave',
            'revisionLabel' => $dokumen['revision_no'] > 0 ? 'Revisi ke-' . $dokumen['revision_no'] : null,
        ]);
    }

    // ============================================================
    // SAVE STATUS
    // ============================================================
    public function saveStatus($id)
    {
        $dokumen = $this->iso00->find($id);
        if (!$dokumen) return redirect()->to('/iso00')->with('error', 'Dokumen tidak ditemukan.');
        if (session()->get('user_id') != $dokumen['uploaded_by'] && session()->get('role') !== 'admin') {
            return redirect()->to('/iso00')->with('error', 'Anda tidak memiliki akses!');
        }

        $this->iso00->update($id, [
            'status'     => 'save',
            'updated_by' => session()->get('user_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/iso00/show/' . $id)
                         ->with('success', 'Status dokumen berhasil diubah menjadi SAVE.');
    }

    public function viewFile($id)
    {
        $dok = $this->iso00->find($id);
        if (!$dok || empty($dok['file_path'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        $fullPath = WRITEPATH . $dok['file_path'];
        if (!file_exists($fullPath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File fisik tidak ada');
        }

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $dok['nama_file'] . '"')
            ->setBody(file_get_contents($fullPath));
    }
}
