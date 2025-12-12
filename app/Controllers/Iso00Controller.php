<?php

namespace App\Controllers;

use App\Models\Iso00Model;
use App\Models\Iso001Model;
use App\Models\UserModel;

class Iso00Controller extends BaseController
{
    protected $iso00;
    protected $iso001;
    protected $user;

    public function __construct()
    {
        $this->iso00  = new Iso00Model();
        $this->iso001 = new Iso001Model();
        $this->user   = new UserModel();
    }

    public function index()
    {
        $data['dokumen'] = $this->iso00
            ->select('iso_00.*, users.fullname, users.foto, users.role')
            ->join('users', 'users.id = iso_00.uploaded_by')
            ->orderBy('iso_00.id', 'DESC')
            ->findAll();

        return view('iso00/index', $data);
    }

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
        $user = $this->user->find(session()->get('user_id'));

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

    public function edit($id)
    {
        $dokumen = $this->iso00->find($id);
        if (!$dokumen) {
            return redirect()->to('/iso00')->with('error', 'Dokumen tidak ditemukan!');
        }
        return view('iso00/edit', ['dokumen' => $dokumen]);
    }

    public function update($id)
    {
        $dokumen = $this->iso00->find($id);

        if (!$dokumen) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan!');
        }

        $file = $this->request->getFile('upload_dokumen');

        // ==============================
        // Simpan versi lama ke tabel histori iso_001
        // ==============================
        if (!empty($dokumen['upload_dokumen'])) {
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
        }

        // ==============================
        // Siapkan data update
        // ==============================
        $updateData = [
            'kode_dokumen'          => $this->request->getPost('kode_dokumen'),
            'nama_dokumen_internal' => $this->request->getPost('nama_dokumen_internal'),
            'keterangan'            => $this->request->getPost('keterangan'),
            'status'                => $this->request->getPost('status') ?? 'revisi',
            'tanggal_efektif'       => $this->request->getPost('tanggal_efektif'),
            'halaman_dokumen'       => $this->request->getPost('halaman_dokumen'),
            'ruang_lingkup'         => $this->request->getPost('ruang_lingkup'),
            'tujuan'                => $this->request->getPost('tujuan'),
            'barcode'               => $this->request->getPost('barcode'),
            'updated_by'            => session()->get('user_id'),
            'updated_at'            => date('Y-m-d H:i:s'),
        ];

        // File baru?
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $updateData['nama_file']      = $file->getClientName();
            $updateData['upload_dokumen'] = file_get_contents($file->getTempName());
        }

        $this->iso00->update($id, $updateData);

        return redirect()->to('/iso00')->with('success', 'Dokumen berhasil diperbarui dan histori tersimpan!');
    }

    public function show($id)
    {
        $data['dokumen'] = $this->iso00
            ->select('iso_00.*, 
                uploader.fullname AS uploader_name,
                uploader.role AS uploader_role,
                uploader.foto AS uploader_foto,
                updater.fullname AS updater_name,
                updater.role AS updater_role,
                updater.foto AS updater_foto
            ')
            ->join('users AS uploader', 'uploader.id = iso_00.uploaded_by')
            ->join('users AS updater', 'updater.id = iso_00.updated_by', 'left')
            ->where('iso_00.id', $id)
            ->first();

        return view('iso00/show', $data);
    }

    public function viewFile($id)
    {
        $dokumen = $this->iso00->find($id);
        if (!$dokumen) return redirect()->back()->with('error', 'Dokumen tidak ditemukan!');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="'.$dokumen['nama_file'].'"')
            ->setBody($dokumen['upload_dokumen']);
    }

    public function download($id)
    {
        $dokumen = $this->iso00->find($id);
        if (!$dokumen) return redirect()->back()->with('error', 'Dokumen tidak ditemukan!');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="'.$dokumen['nama_file'].'"')
            ->setBody($dokumen['upload_dokumen']);
    }

    public function history($id)
    {
        $data['history'] = $this->iso001
                                ->where('iso00_id', $id)
                                ->orderBy('id', 'DESC')
                                ->findAll();

        return view('iso00/history', $data);
    }

    public function allHistory()
    {
        $data['all_history'] = $this->iso001
                                    ->orderBy('id', 'DESC')
                                    ->findAll();

        return view('iso00/all_history', $data);
    }

    public function viewHistoryFile($id)
    {
        $dokumen = $this->iso001->find($id);
        if (!$dokumen) return redirect()->back()->with('error', 'File historis tidak ditemukan!');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="'.$dokumen['nama_file'].'"')
            ->setBody($dokumen['upload_dokumen']);
    }

    public function downloadHistoryFile($id)
    {
        $dokumen = $this->iso001->find($id);
        if (!$dokumen) return redirect()->back()->with('error', 'File historis tidak ditemukan!');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="'.$dokumen['nama_file'].'"')
            ->setBody($dokumen['upload_dokumen']);
    }
}
