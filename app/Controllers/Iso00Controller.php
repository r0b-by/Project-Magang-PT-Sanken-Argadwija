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

    // ============================================================
    // CEK AKSES USER
    // ============================================================
    private function checkAccess($docId)
    {
        $role   = session()->get('role');
        $userId = session()->get('user_id');

        if ($role === 'admin') return true;

        $access = $this->accessUser
            ->select('iso_access_users.id')
            ->join('iso_access_holders', 'iso_access_holders.id = iso_access_users.holder_id')
            ->where('iso_access_users.user_id', $userId)
            ->where('iso_access_holders.dokumen_id', $docId)
            ->first();

        return $access ? true : false;
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

        if ($role === 'admin') {
            $data['dokumen'] = $this->iso00
                ->select('iso_00.*, users.fullname AS uploader_name, users.foto AS uploader_foto, users.role AS uploader_role')
                ->join('users', 'users.id = iso_00.uploaded_by')
                ->orderBy('iso_00.id', 'DESC')
                ->findAll();
        } else {
            $allowedDocs = $this->accessUser
                ->select('iso_access_holders.dokumen_id')
                ->join('iso_access_holders', 'iso_access_holders.id = iso_access_users.holder_id')
                ->where('iso_access_users.user_id', $userId)
                ->findAll();

            $docIds = array_column($allowedDocs, 'dokumen_id');

            $data['dokumen'] = empty($docIds) ? [] : $this->iso00
                ->whereIn('id', $docIds)
                ->orderBy('id', 'DESC')
                ->findAll();
        }

        return view('iso00/index', $data);
    }

    // ============================================================
    // CREATE & STORE DOKUMEN MASTER
    // ============================================================
    public function create()
    {
        return view('iso00/create');
    }

    public function store()
{
    $file = $this->request->getFile('upload_dokumen');

    if (!$file || !$file->isValid()) {
        return redirect()->back()->with('error', 'File tidak valid!');
    }

    if (!is_dir($this->masterPath)) {
        mkdir($this->masterPath, 0775, true);
    }

    // Nama file aman & tidak random
    $finalName = $this->generateSafeFileName($file, $this->masterPath);
    $file->move($this->masterPath, $finalName);

    $this->iso00->save([
        'kode_dokumen'          => $this->request->getPost('kode_dokumen'),
        'nama_dokumen_internal' => $this->request->getPost('nama_dokumen_internal'),
        'nama_file'             => $finalName,
        'file_path'             => 'uploads/iso/masters/' . $finalName,
        'file_size'             => $file->getSize(),
        'mime_type'             => $file->getClientMimeType(),
        'status'                => 'save',
        'uploaded_by'           => session()->get('user_id'),
        'uploaded_at'           => date('Y-m-d H:i:s'),
    ]);

    return redirect()->to('/iso00')->with('success', 'Dokumen berhasil diupload!');
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
    $dokumen = $this->iso00->find($id);
    if (!$dokumen) {
        return redirect()->back()->with('error', 'Dokumen tidak ditemukan!');
    }

    /* ===============================
       1. SIMPAN FILE LAMA KE REVISIONS
       =============================== */
    if (!is_dir($this->revisionPath)) {
        mkdir($this->revisionPath, 0775, true);
    }

    $oldFileFullPath = WRITEPATH . $dokumen['file_path'];

    if (file_exists($oldFileFullPath)) {
        $revisionName = time() . '_' . basename($oldFileFullPath);

        copy($oldFileFullPath, $this->revisionPath . $revisionName);

        $this->iso001->insert([
            'iso00_id'    => $dokumen['id'],
            'nama_file'   => basename($revisionName),
            'file_path'   => 'uploads/iso/revisions/' . $revisionName,
            'file_size'   => $dokumen['file_size'],
            'mime_type'   => $dokumen['mime_type'],
            'status'      => 'revisi',
            'uploaded_by' => session()->get('user_id'),
            'uploaded_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /* ===============================
       2. UPDATE DATA MASTER
       =============================== */
    $update = [
        'kode_dokumen'          => $this->request->getPost('kode_dokumen'),
        'nama_dokumen_internal' => $this->request->getPost('nama_dokumen_internal'),
        'status'                => 'revisi',
        'updated_by'            => session()->get('user_id'),
        'updated_at'            => date('Y-m-d H:i:s'),
    ];

    $file = $this->request->getFile('upload_dokumen');
    if ($file && $file->isValid()) {

        if (!is_dir($this->masterPath)) {
            mkdir($this->masterPath, 0775, true);
        }

        $finalName = $this->generateSafeFileName($file, $this->masterPath);
        $file->move($this->masterPath, $finalName);

        $update['nama_file'] = $finalName;
        $update['file_path'] = 'uploads/iso/masters/' . $finalName;
        $update['file_size'] = $file->getSize();
        $update['mime_type'] = $file->getClientMimeType();
    }

    $this->iso00->update($id, $update);

    return redirect()->to('/iso00')->with('success', 'Dokumen berhasil direvisi');
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
            ->select('iso_00.*, uploader.fullname AS uploader_name, updater.fullname AS updater_name')
            ->join('users AS uploader', 'uploader.id = iso_00.uploaded_by')
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

    // ============================================================
    // HISTORY
    // ============================================================
    public function history($iso00_id)
    {
        if (!$this->checkAccess($iso00_id)) {
            return redirect()->to('/iso00')->with('error', 'Anda tidak memiliki akses!');
        }

        $dokumen = $this->iso00->find($iso00_id);
        if (!$dokumen) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Dokumen tidak ditemukan');
        }

        $history = $this->iso001
            ->where('iso00_id', $iso00_id)
            ->orderBy('uploaded_at', 'DESC')
            ->findAll();

        return view('iso00/history', [
            'dokumen' => $dokumen,
            'history' => $history,
        ]);
    }

    public function allHistory()
    {
        $iso001Model = new Iso001Model();

        $all_history = $iso001Model
            ->select('
                iso_001.id,
                iso_001.versi,
                iso_001.nama_file,
                iso_001.status,
                iso_001.uploaded_at,

                iso_00.kode_dokumen,
                iso_00.nama_dokumen_internal,
                iso_00.ruang_lingkup,
                iso_00.tujuan,

                users.fullname AS uploader_name
                ')
                ->join('iso_00', 'iso_00.id = iso_001.iso00_id')
                ->join('users', 'users.id = iso_001.uploaded_by')
                ->orderBy('iso_001.uploaded_at', 'DESC')
                ->findAll();

            return view('iso00/all_history', [
                'all_history' => $all_history
            ]);
    }

    public function viewHistoryFile($id)
    {
        $history = $this->iso001->find($id);
        if (!$history) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $fullPath = WRITEPATH . $history['file_path'];

        if (!file_exists($fullPath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return $this->response
            ->setHeader('Content-Type', $history['mime_type'])
            ->setHeader('Content-Disposition', 'inline; filename="'.$history['nama_file'].'"')
            ->setBody(file_get_contents($fullPath));
    }


    public function downloadFile($id)
    {
        $dok = $this->iso00->find($id);
        if (!$dok || empty($dok['file_path'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $fullPath = WRITEPATH . $dok['file_path'];

        if (!file_exists($fullPath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return $this->response->download($fullPath, null);
    }

    public function downloadHistoryFile($id)
    {
        $history = $this->iso001->find($id);

        if (!$history) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File history tidak ditemukan');
        }

        return $this->response
            ->download($history['nama_file'], $history['upload_dokumen']);
    }

    public function deleteHistory($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        $history = $this->iso001->find($id);
        if (!$history) {
            return redirect()->back()->with('error', 'History tidak ditemukan');
        }

        $this->iso001->delete($id);

        return redirect()->back()->with('success', 'History revisi berhasil dihapus');
    }
}
