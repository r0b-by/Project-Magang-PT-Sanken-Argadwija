<?php

namespace App\Controllers;

use App\Models\UserModel;

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

        $username = trim($this->request->getPost('username'));
        $password = trim($this->request->getPost('password'));

        if (!$username || !$password) {
            return redirect()->back()->with('error', 'Username dan Password wajib diisi!');
        }

        $user = $model->getUserByUsername($username);

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan!');
        }

        // Cek status akun
        if ($user['status_akun'] === 'nonaktif') {
            return redirect()->back()->with('error', 'Akun anda tidak aktif. Silakan hubungi admin.');
        }

        // Verifikasi password
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
        $userId = session()->get('user_id');

        if ($userId) {
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
