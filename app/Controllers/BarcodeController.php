<?php

namespace App\Controllers;

use App\Models\Iso00Model;
use App\Models\IsoAccessHolderModel;
use CodeIgniter\Controller;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;

class BarcodeController extends Controller
{
    protected $iso;
    protected $holder;

    public function __construct()
    {
        $this->iso    = new Iso00Model();
        $this->holder = new IsoAccessHolderModel();
    }

    // ============================================================
    // Halaman Barcode Admin / Dept
    // ============================================================
    public function index()
    {
        $role = session()->get('role');

        if($role === 'dept') {
            return $this->deptIndex();
        }

        // Admin view
        $belumBarcode = $this->iso->where('barcode', null)->findAll();
        $sudahBarcodeRaw = $this->iso->where('barcode !=', null)->findAll();

        $sudahBarcode = [];
        foreach ($sudahBarcodeRaw as $dok) {
            $dok['barcodeBase64'] = $dok['barcode']
                ? $this->qrCodeBase64($dok['barcode'], 100)
                : null;
            $sudahBarcode[] = $dok;
        }

        return view('barcode/index', [
            'belumBarcode' => $belumBarcode,
            'sudahBarcode' => $sudahBarcode
        ]);
    }

    // ============================================================
    // Halaman Dept — hanya lihat dokumen yang punya akses & sudah barcode
    // ============================================================
    private function deptIndex()
    {
        $userId = session()->get('user_id');

        // Ambil semua dokumen yang dept punya akses melalui holder
        $allowedDocs = $this->holder->where('user_id', $userId)->findAll();
        $docIds = array_column($allowedDocs, 'dokumen_id');

        // Jika tidak ada dokumen, kembalikan array kosong
        if (empty($docIds)) {
            $barcodes = [];
        } else {
            // Ambil dokumen yang sudah memiliki barcode
            $barcodesRaw = $this->iso
                ->whereIn('id', $docIds)
                ->where('barcode IS NOT NULL')
                ->orderBy('id', 'DESC')
                ->findAll();

            $barcodes = [];
            foreach ($barcodesRaw as $dok) {
                // Pastikan barcode ada sebelum generate QR Code
                if (!empty($dok['barcode'])) {
                    $dok['barcodeBase64'] = $this->qrCodeBase64($dok['barcode'], 150);
                } else {
                    $dok['barcodeBase64'] = null;
                }
                $barcodes[] = $dok;
            }
        }

        // Tampilkan view khusus dept dengan hanya dokumen yang memiliki barcode
        return view('barcode/dept_index', [
            'barcodes' => $barcodes
        ]);
    }

    // ============================================================
    // Generate QR Code (Admin)
    // ============================================================
    public function generate($id)
    {
        $dok = $this->iso->find($id);
        if (!$dok) return redirect()->back()->with('error', 'Dokumen tidak ditemukan');

        $url = base_url('scan/detail/' . $dok['id']);

        $this->iso->update($id, [
            'barcode' => $url,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('msg', 'QR Code berhasil digenerate!');
    }

    public function generateBulk()
    {
        $ids = $this->request->getPost('dokumen');
        if (!$ids) return redirect()->back()->with('error', 'Tidak ada dokumen yang dipilih!');

        foreach ($ids as $id) {
            $dok = $this->iso->find($id);
            if ($dok) {
                $url = base_url('scan/detail/' . $dok['id']);
                $this->iso->update($id, [
                    'barcode' => $url,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        return redirect()->back()->with('msg', 'QR Code massal berhasil digenerate!');
    }

    public function delete($id)
    {
        $dok = $this->iso->find($id);
        if (!$dok) return redirect()->back()->with('error', 'Dokumen tidak ditemukan');

        $this->iso->update($id, [
            'barcode' => null,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('msg', 'QR Code berhasil dihapus!');
    }

    // ============================================================
    // Print QR Code
    // ============================================================
    public function print($id)
    {
        $dok = $this->iso->find($id);
        if (!$dok || !$dok['barcode']) return redirect()->back()->with('error', 'QR Code tidak ditemukan!');

        // cek akses dept
        if (!$this->checkDeptAccess($dok)) {
            return redirect()->back()->with('error', 'Akses ditolak!');
        }

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($dok['barcode'])
            ->encoding(new Encoding('UTF-8'))
            ->size(200)
            ->build();

        return $this->response
            ->setHeader('Content-Type', 'image/png')
            ->setBody($result->getString());
    }

    // ============================================================
    // Detail barcode
    // ============================================================
    public function detail($id)
    {
        $dok = $this->iso->find($id);
        if (!$dok) return view('Home/scan/detail', ['error' => 'Dokumen tidak ditemukan']);

        if (!$this->checkDeptAccess($dok)) {
            return view('Home/scan/detail', ['error' => 'Akses ditolak']);
        }

        $barcodeBase64 = null;
        if (!empty($dok['barcode'])) {
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($dok['barcode'])
                ->encoding(new Encoding('UTF-8'))
                ->size(150)
                ->build();

            $barcodeBase64 = base64_encode($result->getString());
        }

        return view('Home/scan/detail', [
            'dok' => $dok,
            'barcodeBase64' => $barcodeBase64
        ]);
    }

    // ============================================================
    // File PDF
    // ============================================================
    public function file($id)
    {
        $dok = $this->iso->find($id);
        if (!$dok || empty($dok['upload_dokumen'])) {
            return $this->response->setStatusCode(404)->setBody('File tidak ditemukan');
        }

        if (!$this->checkDeptAccess($dok)) {
            return $this->response->setStatusCode(403)->setBody('Akses ditolak!');
        }

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="'.$dok['nama_file'].'"')
            ->setBody($dok['upload_dokumen']);
    }

    // ============================================================
    // Helper: generate QR Code base64
    // ============================================================
    private function qrCodeBase64($data, $size = 150)
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size($size)
            ->build();

        return base64_encode($result->getString());
    }

    // ============================================================
    // Helper: cek akses dept
    // ============================================================
    private function checkDeptAccess($dok)
    {
        $role = session()->get('role');
        if ($role === 'admin') return true;

        if ($role !== 'dept') return false;

        $userId = session()->get('user_id');
        $access = $this->holder
            ->where('user_id', $userId)
            ->where('dokumen_id', $dok['id'])
            ->first();

        return $access && !empty($dok['barcode']);
    }
}
