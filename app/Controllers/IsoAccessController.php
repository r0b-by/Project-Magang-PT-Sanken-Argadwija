<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\IsoAccessHolderModel;
use App\Models\IsoAccessUserModel;
use App\Models\IsoAccessDocumentModel;
use App\Models\UserModel;
use App\Models\Iso00Model;

class IsoAccessController extends BaseController
{
    protected $holderModel;
    protected $accessUserModel;
    protected $userModel;
    protected $dokumenModel;

    public function __construct()
    {
        $this->holderModel     = new IsoAccessHolderModel();
        $this->accessUserModel = new IsoAccessUserModel();
        $this->userModel       = new UserModel();
        $this->dokumenModel    = new Iso00Model();
        $this->accessDocModel  = new IsoAccessDocumentModel();
    }

    /* =====================================================
     * INDEX - MASTER HOLDER
     * ===================================================== */
    public function index()
{
    $holders = $this->holderModel->findAll();
    $db = \Config\Database::connect();

    foreach ($holders as &$h) {
        // Ambil daftar dokumen holder ini
        $docs = $db->table('iso_access_documents iad')
            ->select('i.nama_dokumen_internal')
            ->join('iso_00 i', 'i.id = iad.iso00_id')
            ->where('iad.holder_id', $h['id'])
            ->get()
            ->getResultArray();
        $h['dokumen_list'] = array_column($docs, 'nama_dokumen_internal');

        // Ambil daftar user holder ini
        $users = $db->table('iso_access_users iau')
            ->select('u.fullname')
            ->join('users u', 'u.id = iau.user_id')
            ->where('iau.holder_id', $h['id'])
            ->get()
            ->getResultArray();
        $h['user_list'] = array_column($users, 'fullname');
    }

    return view('access/index', compact('holders'));
}

    /* =====================================================
     * CREATE HOLDER
     * ===================================================== */
    public function create()
    {
        return view('access/create');
    }

    public function storeHolder()
    {
        $holderCode = strtoupper(trim($this->request->getPost('holder_code')));

        if (!$holderCode) {
            return redirect()->back()->withInput()->with('error', 'Kode holder wajib diisi!');
        }

        if ($this->holderModel->getByHolderCode($holderCode)) {
            return redirect()->back()->withInput()->with('error', 'Kode holder sudah digunakan!');
        }

        $this->holderModel->insert([
            'holder_code' => $holderCode
        ]);

        return redirect()->to("/access")
            ->with('success', 'Holder berhasil dibuat, silakan assign user & dokumen.');
    }

    /* =====================================================
     * ASSIGN USER & DOKUMEN
     * ===================================================== */
    public function assign($holderCode)
    {
        $holder = $this->holderModel->getByHolderCode($holderCode);
        if (!$holder) return redirect()->to('/access')->with('error', 'Holder tidak ditemukan');

        $assignedUsers = $this->accessUserModel->where('holder_id', $holder['id'])->findAll();

        $dokumen = $this->dokumenModel
            ->select('iso_00.*')
            ->join('iso_access_documents', 'iso_access_documents.iso00_id = iso_00.id', 'left')
            ->groupStart()
                ->where('iso_access_documents.holder_id IS NULL')
                ->orWhere('iso_access_documents.holder_id', $holder['id'])
            ->groupEnd()
            ->orderBy('iso_00.kode_dokumen', 'ASC')
            ->findAll();

        $users = $this->userModel
            ->where('status_akun', 'aktif')
            ->orderBy('fullname', 'ASC')
            ->findAll();

        return view('access/assign', [
            'holder'        => $holder,
            'dokumen'       => $dokumen,
            'users'         => $users,
            'assignedUsers' => $assignedUsers,
        ]);
    }

    public function storeAssignment()
    {
        $holderId  = $this->request->getPost('holder_id');
        $dokumenId = $this->request->getPost('dokumen_id') ?? [];
        $userIds   = $this->request->getPost('user_ids') ?? [];

        if (!$this->holderModel->find($holderId)) {
            return redirect()->back()->with('error', 'Holder tidak valid!');
        }

        /* ===========================
        * DOKUMEN
        * =========================== */

        // Hapus semua dokumen milik holder ini
        $this->accessDocModel
            ->where('holder_id', $holderId)
            ->delete();

        if (!empty($dokumenId)) {
            foreach ($dokumenId as $dId) {

                // 🔴 PENTING: hapus dokumen ini dari holder lain
                $this->accessDocModel
                    ->where('iso00_id', $dId)
                    ->delete();

                // Assign ke holder sekarang
                $this->accessDocModel->insert([
                    'holder_id' => $holderId,
                    'iso00_id'  => $dId,
                    'created_at'=> date('Y-m-d H:i:s'),
                ]);
            }
        }

        /* ===========================
        * USERS
        * =========================== */

        $this->accessUserModel
            ->where('holder_id', $holderId)
            ->delete();

        foreach ($userIds as $userId) {
            if ($this->userModel->find($userId)) {
                $this->accessUserModel->assignUserToHolder($holderId, $userId);
            }
        }

        return redirect()->back()
            ->with('success', 'Hak akses berhasil diperbarui.');
    }

    /* =====================================================
     * EDIT HOLDER (kode holder saja)
     * ===================================================== */
    public function edit($holderId)
    {
        $holder = $this->holderModel->find($holderId);
        if (!$holder) return redirect()->to('/access')->with('error', 'Holder tidak ditemukan!');

        return view('access/edit', ['holder' => $holder]);
    }

    public function updateHolder($holderId)
    {
        $holder = $this->holderModel->find($holderId);
        if (!$holder) return redirect()->to('/access')->with('error', 'Holder tidak ditemukan!');

        $holderCode = strtoupper(trim($this->request->getPost('holder_code')));
        if (!$holderCode) return redirect()->back()->withInput()->with('error', 'Kode holder wajib diisi!');

        $existing = $this->holderModel
            ->where('holder_code', $holderCode)
            ->where('id !=', $holderId)
            ->first();

        if ($existing) return redirect()->back()->withInput()->with('error', 'Kode holder sudah digunakan!');

        $this->holderModel->update($holderId, [
            'holder_code' => $holderCode,
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to("/access/detail/{$holderCode}")
            ->with('success', 'Holder berhasil diperbarui.');
    }

    /* =====================================================
     * DETAIL HOLDER
     * ===================================================== */
    public function detail($holderCode)
    {
        $holder = $this->holderModel->getByHolderCode($holderCode);
        if (!$holder) return redirect()->to('/access')->with('error', 'Holder tidak ditemukan!');

        return view('access/detail', [
            'holder'  => $holder,
            'users'   => $this->accessUserModel->getUsersByHolder($holder['id']),
            'dokumen' => $this->holderModel->getDokumenByHolder($holder['id'])
        ]);
    }

    /* =====================================================
     * EDIT DOKUMEN HOLDER
     * ===================================================== */
    public function editDokumen($holderId)
    {
        $holder = $this->holderModel->find($holderId);
        if (!$holder) {
            return redirect()->to('/access')->with('error', 'Holder tidak ditemukan!');
        }

        // Ambil semua dokumen + informasi holder yang sudah assign
        $dokumen = $this->dokumenModel
            ->select('iso_00.*, iso_access_documents.holder_id AS assigned_holder_id')
            ->join('iso_access_documents', 'iso_access_documents.iso00_id = iso_00.id', 'left')
            ->orderBy('iso_00.kode_dokumen', 'ASC')
            ->findAll();

        // Ambil semua holder (untuk menampilkan kode holder lain)
        $all_holders = $this->holderModel->findAll();

        return view('access/edit_dokumen', [
            'holder'      => $holder,
            'dokumen'     => $dokumen,
            'all_holders' => $all_holders, // 🔹 kirim ke view
        ]);
    }

    public function updateDokumen($holderId)
    {
        $holder = $this->holderModel->find($holderId);
        if (!$holder) {
            return redirect()->back()->with('error', 'Holder tidak ditemukan!');
        }

        // ⬅️ STRING (radio), bukan array
        $dokumenId = $this->request->getPost('dokumen_id');

        // 1️⃣ Hapus dokumen lama milik holder ini
        $this->accessDocModel
            ->where('holder_id', $holderId)
            ->delete();

        // 2️⃣ Jika user memilih dokumen
        if (!empty($dokumenId)) {

            // ⛔ Lepaskan dokumen dari holder lain
            $this->accessDocModel
                ->where('iso00_id', $dokumenId)
                ->delete();

            // ✅ Assign ke holder ini
            $this->accessDocModel->insert([
                'holder_id'  => $holderId,
                'iso00_id'   => $dokumenId,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->back()
        ->with('success', 'Hak akses dokumen berhasil diperbarui.');
    }

    /* =====================================================
     * EDIT USERS HOLDER
     * ===================================================== */
    public function editUsers($holderId)
    {
        $holder = $this->holderModel->find($holderId);
        if (!$holder) return redirect()->to('/access')->with('error', 'Holder tidak ditemukan!');

        $users = $this->userModel
            ->where('status_akun', 'aktif')
            ->where('role', 'dept')
            ->orderBy('fullname', 'ASC')
            ->findAll();

        $assignedUsers = $this->accessUserModel
            ->where('holder_id', $holderId)
            ->findAll();

        return view('access/edit_users', [
            'holder'        => $holder,
            'users'         => $users,
            'assignedUsers' => $assignedUsers,
        ]);
    }

    public function updateUsers($holderId)
    {
        $holder = $this->holderModel->find($holderId);
        if (!$holder) return redirect()->back()->with('error', 'Holder tidak ditemukan!');

        $userIds = $this->request->getPost('user_ids') ?? [];

        // Hapus user lama
        $this->accessUserModel->where('holder_id', $holderId)->delete();

        // Assign user baru
        foreach ($userIds as $userId) {
            $this->accessUserModel->assignUserToHolder($holderId, $userId);
        }

        return redirect()->to("/access/detail/{$holder['holder_code']}")
            ->with('success', 'User holder berhasil diperbarui.');
    }

    /* =====================================================
     * REMOVE USER
     * ===================================================== */
    public function removeUser($accessId)
    {
        $this->accessUserModel->delete($accessId);
        return redirect()->back()->with('success', 'User berhasil dihapus dari holder.');
    }

    /* =====================================================
     * DELETE HOLDER
     * ===================================================== */
    public function deleteHolder($holderId)
    {
        $this->holderModel->delete($holderId);
        return redirect()->to('/access')->with('success', 'Holder berhasil dihapus.');
    }

    /* =====================================================
     * USER SIDE - DOKUMEN
     * ===================================================== */
    public function userDocuments()
    {
        $userId = session()->get('user_id');
        if (!$userId) return redirect()->to('/login');

        return view('user/documents', [
            'dokumen' => $this->accessUserModel->getHoldersByUser($userId)
        ]);
    }

    public function removeDokumen()
    {
        $holderId  = $this->request->getPost('holder_id');
        $dokumenId = $this->request->getPost('dokumen_id');

        $this->accessDocModel
            ->where('holder_id', $holderId)
            ->where('iso00_id', $dokumenId)
            ->delete();

        return redirect()->back()->with('success', 'Hak akses dokumen berhasil dihapus.');
    }

}
