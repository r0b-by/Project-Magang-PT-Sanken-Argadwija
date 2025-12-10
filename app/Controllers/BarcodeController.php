<?php

namespace App\Controllers;

use App\Models\Iso00Model;
use CodeIgniter\Controller;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;

class BarcodeController extends Controller
{
    protected $iso;

    public function __construct()
    {
        $this->iso = new Iso00Model();
    }

    public function index()
    {
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

    public function generate($id)
    {
        $dok = $this->iso->find($id);
        if (!$dok) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan');
        }

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

        if (!$ids) {
            return redirect()->back()->with('error', 'Tidak ada dokumen yang dipilih!');
        }

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
        if (!$dok) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan');
        }

        $this->iso->update($id, [
            'barcode' => null,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('msg', 'QR Code berhasil dihapus!');
    }

    public function print($id)
    {
        $dok = $this->iso->find($id);
        if (!$dok || !$dok['barcode']) {
            return redirect()->back()->with('error', 'QR Code tidak ditemukan!');
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

    public function detail($id)
    {
        $dok = $this->iso->find($id);
        if (!$dok) {
            return view('Home/scan/detail', ['error' => 'Dokumen tidak ditemukan']);
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

    public function file($id)
    {
        $dok = $this->iso->find($id);
        if (!$dok || empty($dok['upload_dokumen'])) {
            return $this->response->setStatusCode(404)->setBody('File tidak ditemukan');
        }

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="'.$dok['nama_file'].'"')
            ->setBody($dok['upload_dokumen']);
    }

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
}
