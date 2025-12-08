<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $user;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->user = new UserModel();
    }

    // ==============================
    // LIST USER
    // ==============================
    public function index()
    {
        $data['users'] = $this->user->findAll();

        return view('users/index', $data);
    }

    // ==============================
    // FORM TAMBAH USER
    // ==============================
    public function create()
    {
        return view('users/create');
    }

    // ==============================
    // SIMPAN USER BARU
    // ==============================
    public function store()
    {
        $rules = [
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[5]',
            'fullname' => 'required',
            'role'     => 'required',
            'status_akun' => 'required',
            'foto' => [
                'uploaded[foto]',
                'mime_in[foto,image/jpg,image/jpeg,image/png]',
                'max_size[foto,2048]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Upload foto
        $file = $this->request->getFile('foto');
        $fotoName = $file->getRandomName();
        $file->move('uploads/foto_user/', $fotoName);

        $this->user->save([
            'username'       => $this->request->getPost('username'),
            'password'       => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'fullname'       => $this->request->getPost('fullname'),
            'role'           => $this->request->getPost('role'),
            'status_akun'    => $this->request->getPost('status_akun'),
            'foto'           => $fotoName,
            'is_online'      => 0,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/users')->with('success', 'User berhasil ditambahkan!');
    }

    // ==============================
    // FORM EDIT USER
    // ==============================
    public function edit($id)
    {
        $data['user'] = $this->user->find($id);

        if (!$data['user']) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan!');
        }

        return view('users/edit', $data);
    }

    // ==============================
    // UPDATE USER
    // ==============================
    public function update($id)
    {
        $dbUser = $this->user->find($id);

        if (!$dbUser) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan!');
        }

        $rules = [
            'fullname' => 'required',
            'role'     => 'required',
            'status_akun' => 'required'
        ];

        // Jika username berubah, cek unik
        if ($dbUser['username'] !== $this->request->getPost('username')) {
            $rules['username'] = 'required|is_unique[users.username]';
        }

        // Validasi foto hanya jika diupload
        if ($this->request->getFile('foto')->isValid()) {
            $rules['foto'] = [
                'uploaded[foto]',
                'mime_in[foto,image/jpg,image/jpeg,image/png]',
                'max_size[foto,2048]'
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $dataUpdate = [
            'username'       => $this->request->getPost('username'),
            'fullname'       => $this->request->getPost('fullname'),
            'role'           => $this->request->getPost('role'),
            'status_akun'    => $this->request->getPost('status_akun'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        // Jika password diisi maka update
        if ($this->request->getPost('password')) {
            $dataUpdate['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        // Jika foto diupload, simpan foto baru
        if ($this->request->getFile('foto')->isValid()) {
            $file = $this->request->getFile('foto');
            $fotoName = $file->getRandomName();
            $file->move('uploads/foto_user/', $fotoName);

            // Hapus foto lama
            if ($dbUser['foto'] && file_exists('uploads/foto_user/' . $dbUser['foto'])) {
                unlink('uploads/foto_user/' . $dbUser['foto']);
            }

            $dataUpdate['foto'] = $fotoName;
        }

        $this->user->update($id, $dataUpdate);

        return redirect()->to('/users')->with('success', 'User berhasil diperbarui!');
    }

    // ==============================
    // HAPUS USER
    // ==============================
    public function delete($id)
    {
        $user = $this->user->find($id);

        if ($user['foto'] && file_exists('uploads/foto_user/' . $user['foto'])) {
            unlink('uploads/foto_user/' . $user['foto']);
        }

        $this->user->delete($id);

        return redirect()->to('/users')->with('success', 'User berhasil dihapus!');
    }
}
