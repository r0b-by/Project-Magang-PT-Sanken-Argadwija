<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\IsoAccessUserModel;
use App\Models\ActivityLogModel;

class DashboardDeptController extends BaseController
{
    protected $accessUser;
    protected $log;

    public function __construct()
    {
        $this->accessUser = new IsoAccessUserModel();
        $this->log        = new ActivityLogModel();
    }

    public function index()
    {
        // Ambil user_id dari session
        $userId = session()->get('user_id');

        if (!$userId) {
            // Jika session user_id tidak ada, redirect ke login
            return redirect()->to('/login');
        }

        // Ambil dokumen yang bisa diakses user (pastikan selalu array)
        $dokumen_saya = $this->accessUser->getDocumentsByUser($userId) ?: [];

        // Ambil 10 log terbaru user (pastikan selalu array)
        $log_saya = $this->log
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->findAll() ?: [];

        // Kirim data ke view
        return view('dashboard/dept', [
            'dokumen_saya' => $dokumen_saya,
            'log_saya'     => $log_saya,
        ]);
    }

    /**
     * Contoh method untuk cek akses dokumen tertentu
     */
    public function cekAksesDokumen(int $dokumenId)
    {
        $userId = session()->get('user_id');

        if ($this->accessUser->userHasAccess($userId, $dokumenId)) {
            return "User memiliki akses ke dokumen ID: {$dokumenId}";
        }

        return "User TIDAK memiliki akses ke dokumen ID: {$dokumenId}";
    }
}
