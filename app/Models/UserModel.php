<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';

    protected $allowedFields = [
        'username',
        'password',
        'fullname',
        'nomor_holder',
        'foto',
        'role',
        'status_akun',
        'is_online',
        'last_active_at',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true; // created_at & updated_at otomatis

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
