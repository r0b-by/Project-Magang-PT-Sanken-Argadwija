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

    // ============================================================
    // FORM SCAN
    // ============================================================
    public function form()
    {
        return view('Home/scan/form');
    }

    // ============================================================
    // PROSES SCAN BARCODE / QR
    // ============================================================
    public function process()
    {
        $barcode = trim($this->request->getPost('barcode'));

        if (!$barcode) {
            return redirect()->back()->with('error', 'QR Code / Barcode tidak boleh kosong.');
        }

        $dok = $this->iso
            ->groupStart()
                ->where('kode_dokumen', $barcode)
                ->orWhere('barcode', $barcode)
            ->groupEnd()
            ->first();

        if (!$dok) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
        }

        return redirect()->to(site_url('scan/detail/' . $dok['id']));
    }

    // ============================================================
    // DETAIL DOKUMEN (PDF VIEWER)
    // ============================================================
    public function detail($id)
    {
        $dok = $this->iso->find($id);

        if (!$dok) {
            return redirect()->to('/scan')->with('error', 'Dokumen tidak ditemukan.');
        }

        return view('Home/scan/detail', [
            'dok' => $dok
        ]);
    }

    // ============================================================
    // STREAM FILE PDF (PDF.JS)
    // ============================================================
    public function file($id)
{
    $dok = $this->iso->find($id);
    if (!$dok || empty($dok['file_path'])) {
        show_404(); // Simpler
    }

    $fullPath = WRITEPATH . $dok['file_path'];
    if (!file_exists($fullPath)) {
        show_404();
    }

    // 💯 PERFECT untuk PDF.js
    header('Content-Type: application/pdf');
    header('Access-Control-Allow-Origin: *');
    header('Content-Disposition: inline');
    header('Content-Length: ' . filesize($fullPath));
    readfile($fullPath);
    exit;
}


}
