<?php

namespace App\Controllers;

use App\Models\Iso00Model;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Iso00Controller extends BaseController
{
    protected $iso00;
    protected $user;

    public function __construct()
    {
        $this->iso00 = new Iso00Model();
        $this->user  = new UserModel();
    }

    public function index()
    {
        $data['dokumen'] = $this->iso00
            ->select('iso_00.*, users.fullname, users.foto, users.role')
            ->join('users', 'users.id = iso_00.uploaded_by')  // Ubah ini
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

        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid!');
        }

        // Ambil isi file sebagai binary
        $pdfData = file_get_contents($file->getTempName());

        // Ambil data user yang sedang login
        $user = $this->user->find(session()->get('user_id'));

        $this->iso00->save([
            'kode_dokumen'   => $this->request->getPost('kode_dokumen'),
            'departement'    => $this->request->getPost('departement'),
            'nama_file'      => $file->getClientName(), // nama asli file
            'upload_dokumen' => $pdfData, // BLOB PDF
            'keterangan'     => $this->request->getPost('keterangan'),
            'status'         => 'save',

            // Uploader info
            'uploaded_by'    => session()->get('user_id'),
            'uploader_name'  => $user['fullname'] ?? 'Unknown',
            'uploader_role'  => $user['role'] ?? 'unknown',
            'uploader_foto'  => $user['foto'] ?? null,
            'uploaded_at'    => date('Y-m-d H:i:s'),

            'barcode'        => $this->request->getPost('barcode')
        ]);

        return redirect()->to('/iso00')->with('success', 'Dokumen berhasil diupload!');
    }

    public function edit($id)
    {
        $dokumen = $this->iso00->find($id);
        
        if (!$dokumen) {
            return redirect()->to('/iso00')->with('error', 'Dokumen tidak ditemukan!');
        }

        // Kirim data dokumen ke view
        $data['dokumen'] = $dokumen;
        
        return view('iso00/edit', $data);
    }

    public function update($id)
    {
        $file = $this->request->getFile('upload_dokumen');
        $updateData = [
            'kode_dokumen' => $this->request->getPost('kode_dokumen'),
            'departement'  => $this->request->getPost('departement'),
            'keterangan'   => $this->request->getPost('keterangan'),
        ];

        if ($file && $file->isValid()) {
            $filename = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/', $filename);
            $updateData['upload_dokumen'] = $filename;
            $updateData['nama_file'] = $filename;
        }

        // Jika ada user yang update, simpan info
        if (session()->has('user_id')) {
            $user = $this->user->find(session()->get('user_id'));
            $updateData['updated_by'] = session()->get('user_id');
            $updateData['updated_at'] = date('Y-m-d H:i:s');
        }

        $this->iso00->update($id, $updateData);

        return redirect()->to('/iso00')->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function detail($id)
    {
        // Panggil method show() yang sudah ada
        return $this->show($id);
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
            ->join('users AS uploader', 'uploader.id = iso_00.uploaded_by') // Ubah ini
            ->join('users AS updater', 'updater.id = iso_00.updated_by', 'left')
            ->where('iso_00.id', $id)
            ->first();

        return view('iso00/show', $data);
    }

    public function viewFile($id)
    {
        $dokumen = $this->iso00->find($id);

        if (!$dokumen) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan!');
        }

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $dokumen['nama_file'] . '"')
            ->setBody($dokumen['upload_dokumen']); // ambil dari database
    }

    public function download($id)
    {
        $dokumen = $this->iso00->find($id);

        if (!$dokumen) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan!');
        }

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $dokumen['nama_file'] . '"')
            ->setBody($dokumen['upload_dokumen']);  
    }

    public function delete($id)
    {
        $this->iso00->delete($id);
        return redirect()->to('/iso00')->with('success', 'Data berhasil dihapus!');
    }
}
