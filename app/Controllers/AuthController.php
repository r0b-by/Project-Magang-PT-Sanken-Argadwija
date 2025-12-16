<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ActivityLogModel;

class AuthController extends BaseController
{
    protected $userModel;
    protected $activityLog;

    public function __construct()
    {
        $this->userModel  = new UserModel();
        $this->activityLog = new ActivityLogModel();
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function process()
    {
        $session = session();

        $username = trim($this->request->getPost('username'));
        $password = trim($this->request->getPost('password'));

        if (!$username || !$password) {
            return redirect()->back()->with('error', 'Username dan Password wajib diisi!');
        }

        $user = $this->userModel->getUserByUsername($username);

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan!');
        }

        if ($user['status_akun'] === 'nonaktif') {
            return redirect()->back()->with('error', 'Akun anda tidak aktif. Silakan hubungi admin.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah!');
        }

        // ==============================
        // SET SESSION
        // ==============================
        $session->set([
            'user_id'     => $user['id'],
            'username'    => $user['username'],
            'fullname'    => $user['fullname'],
            'role'        => $user['role'],
            'foto'        => $user['foto'],
            'isLoggedIn'  => true,
        ]);

        // ==============================
        // UPDATE USER STATUS
        // ==============================
        $this->userModel->update($user['id'], [
            'last_active_at' => date('Y-m-d H:i:s'),
            'is_online'      => 1,
        ]);

        // ==============================
        // LOG LOGIN
        // ==============================
        $this->activityLog->insert([
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'fullname'   => $user['fullname'],
            'role'       => $user['role'],
            'activity'   => 'login',
            'ip_address' => $this->request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->redirectByRole($user['role']);
    }

    private function redirectByRole($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->to('/dashboard/admin');
            case 'dept':
                return redirect()->to('/dashboard/dept');
            default:
                return redirect()->to('/dashboard');
        }
    }

    public function logout()
    {
        $userId = session()->get('user_id');

        if ($userId) {

            // ==============================
            // LOG LOGOUT
            // ==============================
            $this->activityLog->insert([
                'user_id'    => session()->get('user_id'),
                'username'   => session()->get('username'),
                'fullname'   => session()->get('fullname'),
                'role'       => session()->get('role'),
                'activity'   => 'logout',
                'ip_address' => $this->request->getIPAddress(),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // UPDATE STATUS
            $this->userModel->update($userId, [
                'is_online'       => 0,
                'last_active_at'  => date('Y-m-d H:i:s'),
            ]);
        }

        session()->destroy();
        return redirect()->to('/login');
    }
}
