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

    public function __construct()
    {
        $this->iso00      = new Iso00Model();
        $this->iso001     = new Iso001Model();
        $this->user       = new UserModel();
        $this->holder     = new IsoAccessHolderModel();
        $this->accessUser = new IsoAccessUserModel();
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

    // ============================================================
    // INDEX / LIST DOKUMEN
    // ============================================================
    public function index()
    {
        $role   = session()->get('role');
        $userId = session()->get('user_id');

        if ($role === 'admin') {
            $data['dokumen'] = $this->iso00
                ->select('iso_00.*, users.fullname, users.foto, users.role')
                ->join('users', 'users.id = iso_00.uploaded_by')
                ->orderBy('iso_00.id', 'DESC')
                ->findAll();
        } else {
            // Ambil dokumen yang di-assign via holder
            $allowedDocs = $this->accessUser
                ->select('iso_access_holders.dokumen_id')
                ->join('iso_access_holders', 'iso_access_holders.id = iso_access_users.holder_id')
                ->where('iso_access_users.user_id', $userId)
                ->findAll();

            $docIds = array_column($allowedDocs, 'dokumen_id');

            if (empty($docIds)) {
                $data['dokumen'] = [];
            } else {
                $data['dokumen'] = $this->iso00
                    ->whereIn('id', $docIds)
                    ->orderBy('id', 'DESC')
                    ->findAll();
            }
        }

        return view('iso00/index', $data);
    }

    // ============================================================
    // CREATE & STORE
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

        $pdfData = file_get_contents($file->getTempName());
        $user    = $this->user->find(session()->get('user_id'));

        $this->iso00->save([
            'kode_dokumen'          => $this->request->getPost('kode_dokumen'),
            'nama_dokumen_internal' => $this->request->getPost('nama_dokumen_internal'),
            'nama_file'             => $file->getClientName(),
            'upload_dokumen'        => $pdfData,
            'status'                => 'save',
            'tanggal_efektif'       => $this->request->getPost('tanggal_efektif'),
            'halaman_dokumen'       => $this->request->getPost('halaman_dokumen'),
            'ruang_lingkup'         => $this->request->getPost('ruang_lingkup'),
            'tujuan'                => $this->request->getPost('tujuan'),
            'uploaded_by'           => session()->get('user_id'),
            'uploader_name'         => $user['fullname'] ?? 'Unknown',
            'uploader_role'         => $user['role'] ?? 'unknown',
            'uploader_foto'         => $user['foto'] ?? null,
            'uploaded_at'           => date('Y-m-d H:i:s'),
            'barcode'               => $this->request->getPost('barcode')
        ]);

        return redirect()->to('/iso00')->with('success', 'Dokumen berhasil diupload!');
    }

    // ============================================================
    // EDIT & UPDATE
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

        // ================================
        // 1. CEK AKSES
        // ================================
        if (
            session()->get('role') !== 'admin' &&
            $dokumen['uploaded_by'] != session()->get('user_id')
        ) {
            return redirect()->to('/iso00')->with('error', 'Anda tidak memiliki akses!');
        }

        // ================================
        // 2. SIMPAN VERSI LAMA KE ISO_001
        // ================================

        // hitung versi revisi berikutnya
        $lastRev = $this->iso001
            ->where('iso00_id', $dokumen['id'])
            ->countAllResults();

        $versi = 'Rev-' . ($lastRev + 1);

        $this->iso001->insert([
            'iso00_id'      => $dokumen['id'],
            'versi'         => $versi,
            'nama_file'     => $dokumen['nama_file'],
            'upload_dokumen'=> $dokumen['upload_dokumen'],
            'status'        => 'draft',
            'uploaded_by'   => session()->get('user_id'),
            'uploader_name' => session()->get('fullname'),
            'uploader_role' => session()->get('role'),
            'uploaded_at'   => date('Y-m-d H:i:s'),
            'barcode'       => $dokumen['barcode'],
        ]);

        // ================================
        // 3. UPDATE DOKUMEN UTAMA (ISO_00)
        // ================================

        $file = $this->request->getFile('upload_dokumen');

        $update = [
            'kode_dokumen'          => $this->request->getPost('kode_dokumen'),
            'nama_dokumen_internal' => $this->request->getPost('nama_dokumen_internal'),
            'status'                => 'revisi',
            'tanggal_efektif'       => $this->request->getPost('tanggal_efektif'),
            'halaman_dokumen'       => $this->request->getPost('halaman_dokumen'),
            'ruang_lingkup'         => $this->request->getPost('ruang_lingkup'),
            'tujuan'                => $this->request->getPost('tujuan'),
            'barcode'               => $this->request->getPost('barcode'),
            'updated_by'            => session()->get('user_id'),
            'updated_at'            => date('Y-m-d H:i:s'),
        ];

        if ($file && $file->isValid()) {
            $update['nama_file']      = $file->getClientName();
            $update['upload_dokumen'] = file_get_contents($file->getTempName());
        }

        $this->iso00->update($id, $update);

        return redirect()->to('/iso00')->with('success', 'Dokumen berhasil diperbarui!');
    }

    // ============================================================
    // SHOW & VIEW PDF
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
        if (!$this->checkAccess($id)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses!');
        }

        $dokumen = $this->iso00->find($id);

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="'.$dokumen['nama_file'].'"')
            ->setBody($dokumen['upload_dokumen']);
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
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File history tidak ditemukan');
        }

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="'.$history['nama_file'].'"')
            ->setBody($history['upload_dokumen']);
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
