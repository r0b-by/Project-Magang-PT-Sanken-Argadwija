<?php

namespace App\Controllers;

use App\Models\Iso00Model;

class ScanController extends BaseController
{
    protected $iso;

    public function __construct()
    {
        $this->iso = new Iso00Model();
    }

    // Halaman form scan
    public function form()
    {
        return view('Home/scan/form');
    }

    // Proses hasil scan
    public function process()
    {
        $barcode = $this->request->getPost('barcode');

        if (!$barcode) {
            return redirect()->back()->with('error', 'QR Code atau Barcode tidak boleh kosong.');
        }

        // Cari dokumen berdasarkan barcode / kode dokumen
        $item = $this->iso
            ->groupStart()
                ->where('kode_dokumen', $barcode)
                ->orWhere('barcode', $barcode)
            ->groupEnd()
            ->first();

        if (!$item) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
        }

        // Arahkan ke halaman detail scan (bukan barcode/detail!)
        return redirect()->to('/scan/detail/' . $item['id']);
    }

    // Halaman detail setelah scan
    public function detail($id)
    {
        $dok = $this->iso->find($id);

        if (!$dok) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // kirim ke view Home/scan/detail.php
        return view('Home/scan/detail', [
            'dok' => $dok
        ]);
    }

    public function file($id)
    {
        $dok = $this->iso->find($id);

        if (!$dok) {
            return $this->response
                ->setStatusCode(404)
                ->setBody("Dokumen tidak ditemukan");
        }

        // =============================
        // 1. Jika file fisik tersedia
        // =============================
        $path = FCPATH . 'uploads/' . $dok['nama_file'];

        if (!empty($dok['nama_file']) && file_exists($path)) {

            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'inline; filename="' . $dok['nama_file'] . '"')
                ->setHeader('Content-Length', filesize($path))
                ->setHeader('Accept-Ranges', 'bytes')
                ->setBody(file_get_contents($path));
        }

        // =====================================
        // 2. Jika file disimpan sebagai BLOB
        // =====================================
        if (!empty($dok['upload_dokumen'])) {

            $binaryPDF = $dok['upload_dokumen'];
            $size = strlen($binaryPDF);

            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'inline; filename="dokumen.pdf"')
                ->setHeader('Content-Length', $size)
                ->setHeader('Accept-Ranges', 'bytes')
                ->setBody($binaryPDF);
        }

        // Jika kedua opsi tidak tersedia
        return $this->response
            ->setStatusCode(404)
            ->setBody("File PDF tidak ditemukan dalam database maupun folder upload.");
    }

}
