<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ActivityLogModel;

class AuthController extends BaseController
{
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
        $model = new UserModel();
        $log    = new ActivityLogModel();

        $username = trim($this->request->getPost('username'));
        $password = trim($this->request->getPost('password'));

        if (!$username || !$password) {
            return redirect()->back()->with('error', 'Username dan Password wajib diisi!');
        }

        $user = $model->getUserByUsername($username);

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan!');
        }

        if ($user['status_akun'] === 'nonaktif') {
            return redirect()->back()->with('error', 'Akun anda tidak aktif. Silakan hubungi admin.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah!');
        }

        // Simpan session login
        $session->set([
            'user_id'     => $user['id'],
            'username'    => $user['username'],
            'fullname'    => $user['fullname'],
            'role'        => $user['role'],
            'foto'        => $user['foto'],
            'isLoggedIn'  => true,
        ]);

        // Update last_active_at
        $model->update($user['id'], [
            'last_active_at' => date('Y-m-d H:i:s'),
            'is_online'      => 1,
        ]);

        // 1️⃣ SIMPAN LOG LOGIN
        $log->save([
            'user_id'   => $user['id'],
            'activity'  => 'Login ke sistem',
            'ip_address'=> $this->request->getIPAddress(),
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
            case 'karyawan':
                return redirect()->to('/dashboard/karyawan');
            default:
                return redirect()->to('/dashboard');
        }
    }

    public function logout()
    {
        $log = new ActivityLogModel();
        $userId = session()->get('user_id');

        if ($userId) {
            // 2️⃣ SIMPAN LOG LOGOUT
            $log->save([
                'user_id'   => $userId,
                'activity'  => 'Logout dari sistem',
                'ip_address'=> $this->request->getIPAddress(),
            ]);

            $model = new UserModel();
            $model->update($userId, [
                'is_online' => 0,
                'last_active_at' => date('Y-m-d H:i:s'),
            ]);
        }

        session()->destroy();
        return redirect()->to('/login');
    }
}
