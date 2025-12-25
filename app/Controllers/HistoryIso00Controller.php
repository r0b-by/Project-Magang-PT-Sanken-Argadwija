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
    protected $masterPath;

    public function __construct()
    {
        $this->iso00      = new Iso00Model();
        $this->iso001     = new Iso001Model();
        $this->accessUser = new IsoAccessUserModel();
        $this->masterPath = WRITEPATH . 'uploads/iso/masters/';
    }

    /* ============================================================
     * CEK AKSES DOKUMEN
     * ==========================================================*/
    private function checkAccess(int $docId): bool
    {
        if (session()->get('role') === 'admin') {
            return true;
        }

        return (bool) $this->accessUser
            ->join(
                'iso_access_holders',
                'iso_access_holders.id = iso_access_users.holder_id'
            )
            ->where('iso_access_users.user_id', session()->get('user_id'))
            ->where('iso_access_holders.dokumen_id', $docId)
            ->first();
    }

    /* ============================================================
     * HISTORY PER DOKUMEN
     * ==========================================================*/
    public function index(int $iso00_id)
    {
        if (!$this->checkAccess($iso00_id)) {
            return redirect()->to('/iso00')->with('error', 'Akses ditolak');
        }

        $dokumen = $this->iso00->find($iso00_id);
        if (!$dokumen) {
            throw new PageNotFoundException('Dokumen tidak ditemukan');
        }

        $history = $this->iso001
            ->select('iso_001.*, users.fullname AS uploader_name, departments.nama_dept, departments.kode_dept')
            ->join('users', 'users.id = iso_001.uploaded_by', 'left')
            ->join('departments', 'departments.id = iso_001.department_id', 'left')
            ->where('iso_001.iso00_id', $iso00_id)
            ->orderBy('iso_001.uploaded_at', 'DESC')
            ->findAll();

        return view('iso00/history', [
            'dokumen' => $dokumen,
            'history' => $history
        ]);
    }

    /* ============================================================
     * REVISI DOKUMEN (Buat snapshot ke iso_001)
     * ==========================================================*/
    public function revisi(int $id)
    {
        $dokumen = $this->iso00->find($id);
        if (!$dokumen) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan');
        }

        // Cek akses
        if (session()->get('role') !== 'admin' && $dokumen['uploaded_by'] != session()->get('user_id')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses revisi');
        }

        $user = session()->get();
        $oldFile = WRITEPATH . $dokumen['file_path'];

        // Simpan snapshot ke iso_001
        $this->iso001->insert([
            'iso00_id'       => $dokumen['id'],
            'kode_dokumen'   => $dokumen['kode_dokumen'],
            'nama_file'      => $dokumen['nama_file'],
            'file_path'      => $dokumen['file_path'],
            'file_size'      => $dokumen['file_size'],
            'mime_type'      => $dokumen['mime_type'],
            'revision_no'    => $dokumen['revision_no'] + 1,
            'uploaded_by'    => $user['user_id'],
            'department_id'  => $dokumen['department_id'],
            'uploaded_at'    => date('Y-m-d H:i:s'),
            'revision_note'  => $this->request->getPost('catatan_revisi') ?? 'Revisi otomatis'
        ]);

        // Update master dokumen (naikkan revision_no)
        $this->iso00->update($id, [
            'revision_no' => $dokumen['revision_no'] + 1,
            'updated_by'  => $user['user_id'],
            'updated_at'  => date('Y-m-d H:i:s'),
            'status'      => 'revisi'
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil direvisi dan disimpan ke history.');
    }

    /* ============================================================
     * SEMUA HISTORY (ADMIN)
     * ==========================================================*/
    public function all()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/iso00')->with('error', 'Akses ditolak');
        }

        $all_history = $this->iso001
            ->select('
                iso_001.*,
                iso_001.uploaded_at,
                iso_00.kode_dokumen,
                iso_00.nama_dokumen_internal,
                users.fullname AS uploader_name,
                departments.nama_dept,
                departments.kode_dept
            ')
            ->join('iso_00', 'iso_00.id = iso_001.iso00_id', 'left')
            ->join('users', 'users.id = iso_001.uploaded_by', 'left')
            ->join('departments', 'departments.id = iso_001.department_id', 'left')
            ->orderBy('iso_001.uploaded_at', 'DESC')
            ->findAll();

        return view('iso00/all_history', [
            'all_history' => $all_history
        ]);
    }

    /* ============================================================
     * VIEW FILE HISTORY (PDF)
     * ==========================================================*/
    public function view(int $id)
    {
        $history = $this->iso001->find($id);
        if (!$history) {
            throw new PageNotFoundException('History tidak ditemukan');
        }

        $fullPath = WRITEPATH . $history['file_path'];
        if (!file_exists($fullPath)) {
            throw new PageNotFoundException('File fisik tidak ditemukan');
        }

        return $this->response
            ->setHeader('Content-Type', $history['mime_type'])
            ->setHeader('Content-Disposition', 'inline; filename="' . $history['nama_file'] . '"')
            ->setBody(file_get_contents($fullPath));
    }

    /* ============================================================
     * DOWNLOAD FILE HISTORY
     * ==========================================================*/
    public function download(int $id)
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

    /* ============================================================
     * DELETE HISTORY (ADMIN ONLY)
     * ==========================================================*/
    public function delete(int $id)
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
