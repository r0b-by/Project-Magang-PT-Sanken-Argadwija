<?php

namespace App\Controllers;

use App\Models\Iso00Model;

class ScanController extends BaseController
{
    protected $iso00;

    public function __construct()
    {
        $this->iso00 = new Iso00Model();
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
        $item = $this->iso00
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
        $dok = $this->iso00->find($id);

        if (!$dok) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // kirim ke view Home/scan/detail.php
        return view('Home/scan/detail', [
            'dok' => $dok
        ]);
    }
}
