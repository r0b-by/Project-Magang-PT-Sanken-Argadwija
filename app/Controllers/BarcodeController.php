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
    // GENERATE BARCODE (ADMIN)
    // URL: /barcode/generate
    // ============================================================
    public function index()
    {
        $this->checkAdmin();

        $belumBarcode = $this->iso
            ->where('barcode', null)
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('barcode/generate_barcode', [
            'belumBarcode' => $belumBarcode
        ]);
    }

    // ============================================================
    // DAFTAR BARCODE (ADMIN & DEPT)
    // URL: /barcode
    // ============================================================
    public function list()
    {
        $role = session()->get('role');

        // ================= ADMIN =================
        if ($role === 'admin') {

            $docs = $this->iso
                ->where('barcode IS NOT NULL')
                ->orderBy('updated_at', 'DESC')
                ->findAll();

            return view('barcode/index', [
                'sudahBarcode' => $this->withQrBase64($docs, 100)
            ]);
        }

        // ================= DEPT =================
        if ($role === 'dept') {
            return $this->deptList();
        }

        return redirect()->back()->with('error', 'Akses ditolak');
    }

    // ============================================================
    // DAFTAR BARCODE DEPT
    // ============================================================
    private function deptList()
    {
        $userId = session()->get('user_id');

        $docIds = $this->holder
            ->select('iso_access_holders.dokumen_id')
            ->join('iso_access_users', 'iso_access_users.holder_id = iso_access_holders.id')
            ->where('iso_access_users.user_id', $userId)
            ->findColumn('dokumen_id');

        if (empty($docIds)) {
            return view('barcode/index', ['sudahBarcode' => []]);
        }

        $docs = $this->iso
            ->whereIn('id', $docIds)
            ->where('barcode IS NOT NULL')
            ->orderBy('updated_at', 'DESC')
            ->findAll();

        return view('barcode/index', [
            'sudahBarcode' => $this->withQrBase64($docs, 150)
        ]);
    }

    // ============================================================
    // GENERATE SINGLE QR (ADMIN)
    // ============================================================
    public function generate($id)
    {
        $this->checkAdmin();

        if (!$this->iso->find($id)) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan');
        }

        $this->iso->update($id, [
            'barcode'    => base_url('scan/detail/' . $id),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('msg', 'QR Code berhasil digenerate');
    }

    // ============================================================
    // GENERATE MASSAL (ADMIN)
    // ============================================================
    public function generateBulk()
    {
        $this->checkAdmin();

        $ids = $this->request->getPost('dokumen');

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada dokumen dipilih');
        }

        foreach ($ids as $id) {
            $this->iso->update($id, [
                'barcode'    => base_url('scan/detail/' . $id),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->back()->with('msg', 'QR Code massal berhasil digenerate');
    }

    // ============================================================
    // DELETE QR (ADMIN)
    // ============================================================
    public function delete($id)
    {
        $this->checkAdmin();

        if (!$this->iso->find($id)) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan');
        }

        $this->iso->update($id, [
            'barcode'    => null,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('msg', 'QR Code berhasil dihapus');
    }

    // ============================================================
    // PRINT QR (ADMIN & DEPT)
    // ============================================================
    public function print($id)
    {
        $dok = $this->iso->find($id);
        if (!$dok || empty($dok['barcode'])) {
            return redirect()->back()->with('error', 'QR Code tidak ditemukan');
        }

        // ❗ PRINT tetap butuh login
        if (!$this->checkDeptAccess($dok)) {
            return redirect()->back()->with('error', 'Akses ditolak');
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
    // DETAIL HASIL SCAN (PUBLIK - TANPA LOGIN)
    // ============================================================
    public function detail($id)
    {
        $dok = $this->iso->find($id);

        if (!$dok) {
            return view('Home/scan/detail', [
                'error' => 'Dokumen tidak ditemukan'
            ]);
        }

        if (empty($dok['barcode'])) {
            return view('Home/scan/detail', [
                'error' => 'Dokumen belum memiliki QR Code'
            ]);
        }

        return view('Home/scan/detail', [
            'dok' => $dok
        ]);
    }

    // ============================================================
    // HELPER — TAMBAH QR BASE64
    // ============================================================
    private function withQrBase64(array $docs, int $size)
    {
        foreach ($docs as &$dok) {
            $dok['barcodeBase64'] = $this->qrCodeBase64($dok['barcode'], $size);
        }
        return $docs;
    }

    // ============================================================
    // HELPER — QR BASE64
    // ============================================================
    private function qrCodeBase64($data, $size = 150)
    {
        return base64_encode(
            Builder::create()
                ->writer(new PngWriter())
                ->data($data)
                ->encoding(new Encoding('UTF-8'))
                ->size($size)
                ->build()
                ->getString()
        );
    }

    // ============================================================
    // HELPER — CEK AKSES LOGIN (ADMIN & DEPT)
    // ============================================================
    private function checkDeptAccess($dok)
    {
        $role = session()->get('role');

        if ($role === 'admin') return true;
        if ($role !== 'dept') return false;

        return (bool) $this->holder
            ->join('iso_access_users', 'iso_access_users.holder_id = iso_access_holders.id')
            ->where('iso_access_users.user_id', session()->get('user_id'))
            ->where('iso_access_holders.dokumen_id', $dok['id'])
            ->first();
    }

    private function checkAdmin()
    {
        if (session()->get('role') !== 'admin') {
            exit('Akses ditolak');
        }
    }
}
 