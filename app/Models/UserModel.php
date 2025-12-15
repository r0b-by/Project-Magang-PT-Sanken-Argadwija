<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username',
        'password',
        'fullname',
        'foto',
        'role',
        'status_akun',
        'is_online',
        'last_active_at',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;

    /**
     * Ambil user berdasarkan username
     */
    public function getUserByUsername(string $username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * ✅ Ambil SEMUA user AKTIF
     * Digunakan untuk:
     * - Assign Holder
     * - Dropdown User
     * - Hak Akses Dokumen
     */
    public function getActiveUsers()
    {
        return $this->where('status_akun', 'aktif')
                    ->orderBy('fullname', 'ASC')
                    ->findAll();
    }

    /**
     * (Opsional tapi direkomendasikan)
     * Ambil user aktif berdasarkan role
     */
    public function getActiveUsersByRole(string $role)
    {
        return $this->where([
                        'status_akun' => 'aktif',
                        'role'        => $role
                    ])
                    ->orderBy('fullname', 'ASC')
                    ->findAll();
    }

    /**
     * Ambil fullname user (API ringan)
     */
    public function getFullnameById(int $id)
    {
        return $this->select('fullname')
                    ->where('id', $id)
                    ->first();
    }
}
