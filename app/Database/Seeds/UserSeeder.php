<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Admin Default
            [
                'username'       => 'admin',
                'password'       => password_hash('admin123', PASSWORD_DEFAULT),
                'fullname'       => 'Administrator Sistem',
                'foto'           => 'default.png',
                'role'           => 'admin',
                'status_akun'    => 'aktif',
                'is_online'      => 0,
                'last_active_at' => null,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],

            // Dept User
            [
                'username'       => 'dept1',
                'password'       => password_hash('dept123', PASSWORD_DEFAULT),
                'fullname'       => 'Petugas Departemen LOGISTIK',
                'foto'           => 'default.png',
                'role'           => 'dept',
                'status_akun'    => 'aktif',
                'is_online'      => 0,
                'last_active_at' => null,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            // Dept User
            [
                'username'       => 'dept2',
                'password'       => password_hash('dept123', PASSWORD_DEFAULT),
                'fullname'       => 'Petugas Departemen IT',
                'foto'           => 'default.png',
                'role'           => 'dept',
                'status_akun'    => 'aktif',
                'is_online'      => 0,
                'last_active_at' => null,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert batch
        $this->db->table('users')->insertBatch($data);
    }
}
