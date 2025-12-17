<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\IsoAccessHolderModel;
use App\Models\IsoAccessUserModel;
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
    }

    /* =====================================================
     * INDEX - MASTER HOLDER
     * ===================================================== */
    public function index()
{
    $holders = $this->holderModel->getAllHolders();

    // Ambil user untuk masing-masing holder
    foreach ($holders as &$h) {
        $users = $this->accessUserModel->getUsersByHolder($h['id']);
        $h['users'] = $users; // tambahkan ke array holder
    }

    return view('access/index', ['holders' => $holders]);
}

public function getUsersByHolder(int $holderId)
{
    return $this->select('
            iso_access_users.id AS access_id,
            users.id AS user_id,
            users.fullname,
            users.username
        ')
        ->join('users', 'users.id = iso_access_users.user_id')
        ->where('iso_access_users.holder_id', $holderId)
        ->orderBy('users.fullname', 'ASC')
        ->findAll();
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
    private function checkAccess($docId)
    {
        $role   = session()->get('role');
        $userId = session()->get('user_id');

        if ($role === 'admin') return true;

        $access = $this->accessUserModel
            ->select('iso_access_users.id')
            ->join('iso_access_holders', 'iso_access_holders.id = iso_access_users.holder_id')
            ->where('iso_access_users.user_id', $userId)
            ->where('iso_access_holders.dokumen_id', $docId)
            ->first();

        return $access ? true : false;
    }

    public function assign($holderCode)
    {
        $holder = $this->holderModel->where('holder_code', $holderCode)->first();

        if (!$holder) {
            return redirect()->to('/access')->with('error', 'Holder tidak ditemukan');
        }

        $assignedUsers = $this->accessUserModel->where('holder_id', $holder['id'])->findAll();

        $dokumen = $this->dokumenModel
            ->select('iso_00.*')
            ->join('iso_access_holders', 'iso_access_holders.dokumen_id = iso_00.id', 'left')
            ->groupStart()
                ->where('iso_access_holders.dokumen_id IS NULL')
                ->orWhere('iso_access_holders.id', $holder['id'])
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
        $dokumenId = $this->request->getPost('dokumen_id');
        $userIds   = $this->request->getPost('user_ids') ?? [];

        $holder = $this->holderModel->find($holderId);
        if (!$holder) {
            return redirect()->back()->with('error', 'Holder tidak valid!');
        }

        if ($dokumenId && $this->holderModel->isDokumenUsed($dokumenId, $holderId)) {
            return redirect()->back()->with('error', 'Dokumen sudah digunakan holder lain!');
        }

        $this->holderModel->update($holderId, ['dokumen_id' => $dokumenId ?: null]);

        foreach ($userIds as $userId) {
            $this->accessUserModel->assignUserToHolder($holderId, $userId);
        }

        return redirect()->to("/access/detail/{$holder['holder_code']}")
            ->with('success', 'Hak akses berhasil diperbarui.');
    }

    /* =====================================================
     * EDIT HOLDER (KODE HOLDER SAJA)
     * ===================================================== */
    public function edit($holderId)
    {
        $holder = $this->holderModel->find($holderId);

        if (!$holder) {
            return redirect()->to('/access')->with('error', 'Holder tidak ditemukan!');
        }

        return view('access/edit', ['holder' => $holder]);
    }

    public function updateHolder($holderId)
    {
        $holder = $this->holderModel->find($holderId);
        if (!$holder) {
            return redirect()->to('/access')->with('error', 'Holder tidak ditemukan!');
        }

        $holderCode = strtoupper(trim($this->request->getPost('holder_code')));
        if (!$holderCode) {
            return redirect()->back()->withInput()->with('error', 'Kode holder wajib diisi!');
        }

        $existing = $this->holderModel
            ->where('holder_code', $holderCode)
            ->where('id !=', $holderId)
            ->first();

        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Kode holder sudah digunakan!');
        }

        $this->holderModel->update($holderId, [
            'holder_code' => $holderCode,
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to("/access/detail/{$holderCode}")
            ->with('success', 'Holder berhasil diperbarui.');
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

        $dokumen = $this->dokumenModel
            ->select('iso_00.*')
            ->join('iso_access_holders', 'iso_access_holders.dokumen_id = iso_00.id', 'left')
            ->groupStart()
                ->where('iso_access_holders.dokumen_id IS NULL')
                ->orWhere('iso_access_holders.id', $holderId)
            ->groupEnd()
            ->orderBy('iso_00.kode_dokumen', 'ASC')
            ->findAll();

        return view('access/edit_dokumen', [
            'holder'  => $holder,
            'dokumen' => $dokumen
        ]);
    }

    public function updateDokumen($holderId)
    {
        $holder = $this->holderModel->find($holderId);
        if (!$holder) {
            return redirect()->back()->with('error', 'Holder tidak ditemukan!');
        }

        $dokumenId = $this->request->getPost('dokumen_id');

        if ($dokumenId && $this->holderModel->isDokumenUsed($dokumenId, $holderId)) {
            return redirect()->back()->with('error', 'Dokumen sudah digunakan holder lain!');
        }

        $this->holderModel->update($holderId, [
            'dokumen_id' => $dokumenId ?: null,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to("/access/detail/{$holder['holder_code']}")
            ->with('success', 'Dokumen holder berhasil diperbarui.');
    }

    /* =====================================================
     * EDIT USER HOLDER
     * ===================================================== */
    public function editUsers($holderId)
    {
        $holder = $this->holderModel->find($holderId);
        if (!$holder) {
            return redirect()->to('/access')->with('error', 'Holder tidak ditemukan!');
        }

        // Ambil hanya user dengan role 'dept' dan status aktif
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
        if (!$holder) {
            return redirect()->back()->with('error', 'Holder tidak ditemukan!');
        }

        $userIds = $this->request->getPost('user_ids') ?? [];

        // Hapus semua user sebelumnya
        $this->accessUserModel->where('holder_id', $holderId)->delete();

        // Assign user baru
        foreach ($userIds as $userId) {
            $this->accessUserModel->assignUserToHolder($holderId, $userId);
        }

        return redirect()->to("/access/detail/{$holder['holder_code']}")
            ->with('success', 'User holder berhasil diperbarui.');
    }

    /* =====================================================
     * DETAIL HOLDER
     * ===================================================== */
    public function detail($holderCode)
    {
        $holder = $this->holderModel->getByHolderCode($holderCode);
        if (!$holder) {
            return redirect()->to('/access')->with('error', 'Holder tidak ditemukan!');
        }

        return view('access/detail', [
            'holder' => $holder,
            'users'  => $this->accessUserModel->getUsersByHolder($holder['id'])
        ]);
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
}
