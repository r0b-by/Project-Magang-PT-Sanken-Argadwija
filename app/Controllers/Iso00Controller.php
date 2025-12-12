<?php

namespace App\Controllers;

use App\Models\Iso00Model;
use App\Models\Iso001Model;
use App\Models\UserModel;
use App\Models\IsoAccessHolderModel;

class Iso00Controller extends BaseController
{
    protected $iso00;
    protected $iso001;
    protected $user;
    protected $holder;

    public function __construct()
    {
        $this->iso00  = new Iso00Model();
        $this->iso001 = new Iso001Model();
        $this->user   = new UserModel();
        $this->holder = new IsoAccessHolderModel();
    }

    // ============================================================
    // CEK AKSES HOLDER
    // ============================================================
    private function checkAccess($docId)
    {
        $role   = session()->get('role');
        $userId = session()->get('user_id');

        if ($role === 'admin') {
            return true; // admin bebas akses
        }

        $check = $this->holder
            ->where('user_id', $userId)
            ->where('dokumen_id', $docId)
            ->first();

        return $check ? true : false;
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
            // dept hanya lihat dokumen yang memiliki akses
            $allowedDocs = $this->holder->where('user_id', $userId)->findAll();
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
    // CREATE
    // ============================================================
    public function create()
    {
        return view('iso00/create');
    }

    // ============================================================
    // STORE
    // ============================================================
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
    // EDIT
    // ============================================================
    public function edit($id)
    {
        $dokumen = $this->iso00->find($id);

        if (!$dokumen) {
            return redirect()->to('/iso00')->with('error', 'Dokumen tidak ditemukan!');
        }

        // dept hanya bisa edit dokumen yang mereka upload
        if(session()->get('role') !== 'admin' && $dokumen['uploaded_by'] != session()->get('user_id')) {
            return redirect()->to('/iso00')->with('error', 'Anda tidak memiliki akses mengedit dokumen ini!');
        }

        return view('iso00/edit', ['dokumen' => $dokumen]);
    }

    // ============================================================
    // UPDATE
    // ============================================================
    public function update($id)
    {
        $dokumen = $this->iso00->find($id);

        if (!$dokumen) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan!');
        }

        if(session()->get('role') !== 'admin' && $dokumen['uploaded_by'] != session()->get('user_id')) {
            return redirect()->to('/iso00')->with('error', 'Anda tidak memiliki akses mengubah dokumen ini!');
        }

        $file = $this->request->getFile('upload_dokumen');

        // Simpan versi lama ke iso_001
        $this->iso001->insert([
            'iso00_id'              => $dokumen['id'],
            'kode_dokumen'          => $dokumen['kode_dokumen'],
            'nama_dokumen_internal' => $dokumen['nama_dokumen_internal'],
            'nama_file'             => $dokumen['nama_file'],
            'upload_dokumen'        => $dokumen['upload_dokumen'],
            'keterangan'            => $dokumen['keterangan'],
            'status'                => 'revisi',
            'tanggal_efektif'       => $dokumen['tanggal_efektif'],
            'halaman_dokumen'       => $dokumen['halaman_dokumen'],
            'ruang_lingkup'         => $dokumen['ruang_lingkup'],
            'tujuan'                => $dokumen['tujuan'],
            'uploaded_by'           => $dokumen['uploaded_by'],
            'uploader_name'         => $dokumen['uploader_name'],
            'uploaded_at'           => $dokumen['uploaded_at'],
            'barcode'               => $dokumen['barcode']
        ]);

        $update = [
            'kode_dokumen'          => $this->request->getPost('kode_dokumen'),
            'nama_dokumen_internal' => $this->request->getPost('nama_dokumen_internal'),
            'keterangan'            => $this->request->getPost('keterangan'),
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
    // SHOW
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

    // ============================================================
    // VIEW PDF
    // ============================================================
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
    public function history($id)
    {
        if (!$this->checkAccess($id)) {
            return redirect()->to('/iso00')->with('error', 'Anda tidak memiliki akses!');
        }

        $data['history'] = $this->iso001
            ->where('iso00_id', $id)
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('iso00/history', $data);
    }

    public function allHistory()
    {
        $role = session()->get('role');

        if ($role !== 'admin') {
            return redirect()->to('/iso00')->with('error', 'Akses ditolak!');
        }

        $data['history'] = $this->iso001
            ->select('iso_001.*, users.fullname, iso_00.nama_dokumen_internal')
            ->join('users', 'users.id = iso_001.uploaded_by')
            ->join('iso_00', 'iso_00.id = iso_001.iso00_id')
            ->orderBy('iso_001.id', 'DESC')
            ->findAll();

        return view('iso00/all_history', $data);
    }
}
