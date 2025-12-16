<?php

namespace App\Controllers;

use App\Models\Iso00Model;
use App\Models\Iso001Model;
use App\Models\IsoAccessUserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class HistoryIso00Controller extends BaseController
{
    protected $iso00;
    protected $iso001;
    protected $accessUser;

    public function __construct()
    {
        $this->iso00      = new Iso00Model();
        $this->iso001     = new Iso001Model();
        $this->accessUser = new IsoAccessUserModel();
    }

    // ============================================================
    // CEK AKSES DOKUMEN
    // ============================================================
    private function checkAccess($docId)
    {
        if (session()->get('role') === 'admin') {
            return true;
        }

        return (bool) $this->accessUser
            ->join('iso_access_holders', 'iso_access_holders.id = iso_access_users.holder_id')
            ->where('iso_access_users.user_id', session()->get('user_id'))
            ->where('iso_access_holders.dokumen_id', $docId)
            ->first();
    }

    // ============================================================
    // HISTORY PER DOKUMEN
    // ============================================================
    public function index($iso00_id)
    {
        if (!$this->checkAccess($iso00_id)) {
            return redirect()->to('/iso00')->with('error', 'Akses ditolak');
        }

        $dokumen = $this->iso00->find($iso00_id);
        if (!$dokumen) {
            throw new PageNotFoundException('Dokumen tidak ditemukan');
        }

        $history = $this->iso001
            ->where('iso00_id', $iso00_id)
            ->orderBy('uploaded_at', 'DESC')
            ->findAll();

        return view('iso00/history', [
            'dokumen' => $dokumen,
            'history' => $history
        ]);
    }

    // ============================================================
    // SEMUA HISTORY (ADMIN)
    // ============================================================
    public function all()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/iso00')->with('error', 'Akses ditolak');
        }

        $all_history = $this->iso001
            ->select('
                iso_001.*,
                iso_00.kode_dokumen,
                iso_00.nama_dokumen_internal,
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

    // ============================================================
    // VIEW FILE HISTORY (PDF)
    // ============================================================
    public function view($id)
    {
        $history = $this->iso001->find($id);
        if (!$history) {
            throw new PageNotFoundException();
        }

        $fullPath = WRITEPATH . $history['file_path'];
        if (!file_exists($fullPath)) {
            throw new PageNotFoundException();
        }

        return $this->response
            ->setHeader('Content-Type', $history['mime_type'])
            ->setHeader('Content-Disposition', 'inline; filename="'.$history['nama_file'].'"')
            ->setBody(file_get_contents($fullPath));
    }

    // ============================================================
    // DOWNLOAD FILE HISTORY
    // ============================================================
    public function download($id)
    {
        $history = $this->iso001->find($id);
        if (!$history) {
            throw new PageNotFoundException('History tidak ditemukan');
        }

        $path = WRITEPATH . $history['file_path'];
        if (!file_exists($path)) {
            throw new PageNotFoundException('File tidak ditemukan');
        }

        return $this->response->download($path, null);
    }

    // ============================================================
    // DELETE HISTORY (ADMIN ONLY)
    // ============================================================
    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        $history = $this->iso001->find($id);
        if (!$history) {
            return redirect()->back()->with('error', 'History tidak ditemukan');
        }

        $path = WRITEPATH . $history['file_path'];
        if (is_file($path)) {
            unlink($path);
        }

        $this->iso001->delete($id);

        return redirect()->back()->with('success', 'History berhasil dihapus');
    }
}
