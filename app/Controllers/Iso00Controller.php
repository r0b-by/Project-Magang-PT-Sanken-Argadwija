<?php

namespace App\Controllers;

use App\Models\Iso00Model;
use App\Models\Iso001Model;
use App\Models\UserModel;
use App\Models\IsoAccessHolderModel;
use App\Models\IsoAccessUserModel;

class Iso00Controller extends BaseController
{
    protected $iso00;
    protected $iso001;
    protected $user;
    protected $holder;
    protected $accessUser;
    protected $masterPath;
    protected $revisionPath;

    public function __construct()
    {
        $this->iso00      = new Iso00Model();
        $this->iso001     = new Iso001Model();
        $this->user       = new UserModel();
        $this->holder     = new IsoAccessHolderModel();
        $this->accessUser = new IsoAccessUserModel();
        $this->masterPath   = WRITEPATH . 'uploads/iso/masters/';
        $this->revisionPath = WRITEPATH . 'uploads/iso/revisions/';
    }

    private function currentUser(): array
    {
        return [
            'id'       => session()->get('user_id'),
            'name'     => session()->get('fullname') ?? 'Administrator Sistem',
            'role'     => session()->get('role') ?? 'admin',
            'foto'     => session()->get('foto') ?? 'default.png',
        ];
    }

    // ============================================================
    // CEK AKSES USER
    // ============================================================
    private function checkAccess($docId)
    {
        $role   = session()->get('role');
        $userId = session()->get('user_id');

        if ($role === 'admin') return true;

        return $this->accessUser
            ->join(
                'iso_access_documents',
                'iso_access_documents.holder_id = iso_access_users.holder_id'
            )
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

        /* =========================================================
        * QUERY DASAR DOKUMEN + UPLOADER + UPDATER
        * =======================================================*/
        $baseQuery = $this->iso00
            ->select('
                iso_00.*,

                uploader.fullname AS uploader_name,
                uploader.role     AS uploader_role,
                uploader.foto     AS uploader_foto,

                updater.fullname AS updater_name,
                updater.role     AS updater_role,
                updater.foto     AS updater_foto
            ')
            ->join('users AS uploader', 'uploader.id = iso_00.uploaded_by', 'left')
            ->join('users AS updater', 'updater.id = iso_00.updated_by', 'left');

        /* =========================================================
        * ADMIN → SEMUA DOKUMEN
        * =======================================================*/
        if ($role === 'admin') {

            $dokumen = $baseQuery
                ->orderBy('iso_00.id', 'DESC')
                ->findAll();

        }
        /* =========================================================
        * NON-ADMIN → SESUAI HAK AKSES HOLDER
        * =======================================================*/
        else {

        $allowedDocs = $this->accessUser
            ->select('iso_access_documents.iso00_id')
            ->join(
                'iso_access_documents',
                'iso_access_documents.holder_id = iso_access_users.holder_id'
            )
            ->where('iso_access_users.user_id', $userId)
            ->findAll();

        $docIds = array_column($allowedDocs, 'iso00_id');

        $dokumen = empty($docIds)
            ? []
            : $baseQuery
                ->whereIn('iso_00.id', $docIds)
                ->orderBy('iso_00.id', 'DESC')
                ->findAll();
    }

        /* =========================================================
        * TAMBAHKAN HOLDER & USER KE TIAP DOKUMEN
        * =======================================================*/
        foreach ($dokumen as &$doc) {

            $holders = $this->holder->getHolderWithUsersByDokumen($doc['id']);

            $doc['holder_code']  = $holders[0]['holder_code'] ?? null;
            $doc['holder_users'] = [];

            foreach ($holders as $h) {
                if (!empty($h['fullname'])) {
                    $doc['holder_users'][] = $h['fullname'];
                }
            }
        }

        return view('iso00/index', [
            'dokumen' => $dokumen
        ]);
    }

    // ============================================================
    // CREATE & STORE DOKUMEN MASTERa
    // ============================================================
    public function create()
    {
        return view('iso00/create');
    }

    public function store()
    {
        $file = $this->request->getFile('upload_dokumen');
        if (!$file || !$file->isValid()) {
            return back()->withInput()->with('error', 'File tidak valid');
        }

        $user = $this->currentUser();

        if (!is_dir($this->masterPath)) {
            mkdir($this->masterPath, 0775, true);
        }

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
            'status'                => 'save',
            'uploaded_by'           => $user['id'],
            'uploader_name'         => $user['name'],
            'uploader_role'         => $user['role'],
            'uploader_foto'         => $user['foto'],
            'uploaded_at'           => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/iso00')->with('success', 'Dokumen berhasil diupload');
    }


    // ============================================================
    // EDIT & UPDATE DOKUMEN MASTER + REVISI
    // ============================================================
    public function edit($id)
    {
        $dokumen = $this->iso00->find($id);
        if (!$dokumen) return redirect()->to('/iso00')->with('error', 'Dokumen tidak ditemukan!');
        if (session()->get('role') !== 'admin' && $dokumen['uploaded_by'] != session()->get('user_id')) {
            return redirect()->to('/iso00')->with('error', 'Anda tidak memiliki akses mengedit dokumen ini!');
        }

        return view('iso00/edit', ['dokumen' => $dokumen]);
    }

    public function update($id)
    {
        $master = $this->iso00->find($id);
        if (!$master) {
            return back()->with('error', 'Dokumen tidak ditemukan');
        }

        $user    = $this->currentUser();
        $oldFile = WRITEPATH . $master['file_path'];

        /* =========================================================
        * 1. SIMPAN SNAPSHOT KE ISO_001 (HISTORY)
        * =======================================================*/
        $this->iso001->addRevision($master, [
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
            'status'                => 'revisi',
            'updated_by'            => $user['id'],
            'updated_at'            => date('Y-m-d H:i:s'),
        ];

        /* =========================================================
        * 3. JIKA ADA FILE BARU
        * =======================================================*/
        $file = $this->request->getFile('upload_dokumen');
        if ($file && $file->isValid() && !$file->hasMoved()) {

            if (!is_dir($this->masterPath)) {
                mkdir($this->masterPath, 0775, true);
            }

            $newName = $this->generateSafeFileName($file, $this->masterPath);
            $file->move($this->masterPath, $newName);

            // hapus file lama setelah sukses
            if (!empty($master['file_path']) && is_file($oldFile)) {
                unlink($oldFile);
            }

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
            ->with('success', 'Dokumen berhasil direvisi');
    }

    // ============================================================
    // SHOW DOKUMEN MASTER
    // ============================================================
    public function show($id)
    {
        if (!$this->checkAccess($id)) {
            return redirect()->to('/iso00')->with('error', 'Anda tidak memiliki akses!');
        }

        $data['dokumen'] = $this->iso00
            ->select('
                iso_00.*,
                uploader.fullname AS uploader_name,
                updater.fullname AS updater_name
            ')
            ->join('users AS uploader', 'uploader.id = iso_00.uploaded_by', 'left')
            ->join('users AS updater', 'updater.id = iso_00.updated_by', 'left')
            ->where('iso_00.id', $id)
            ->first();

        return view('iso00/show', $data);
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
