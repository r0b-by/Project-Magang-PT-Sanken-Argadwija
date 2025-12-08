<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username', 'password', 'fullname', 'foto', 'role',
        'status_akun', 'is_online', 'last_active_at'
    ];

    protected $useTimestamps = true; // created_at & updated_at otomatis

    /**
     * Ambil user berdasarkan username
     */
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
