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
                'username'       => 'admin-1',
                'password'       => password_hash('admin123', PASSWORD_DEFAULT),
                'fullname'       => 'admin hendrik',
                'foto'           => 'default.png',
                'role'           => 'admin',
                'status_akun'    => 'aktif',
                'is_online'      => 0,
                'last_active_at' => null,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],

            //admin defoult 2
            [
                'username'       => 'admin-2',
                'password'       => password_hash('admin123', PASSWORD_DEFAULT),
                'fullname'       => 'admin robby',
                'foto'           => 'default.png',
                'role'           => 'admin',
                'status_akun'    => 'aktif',
                'is_online'      => 0,
                'last_active_at' => null,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],

            // // Dept User
            [
                'username'       => 'dept IT',
                'password'       => password_hash('dept123', PASSWORD_DEFAULT),
                'fullname'       => 'taufik',
                'foto'           => 'default.png',
                'role'           => 'dept',
                'status_akun'    => 'aktif',
                'is_online'      => 0,
                'last_active_at' => null,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            // // Dept User
            [
                'username'       => 'dept ISO',
                'password'       => password_hash('dept123', PASSWORD_DEFAULT),
                'fullname'       => 'Hednrik',
                'foto'           => 'default.png',
                'role'           => 'dept',
                'status_akun'    => 'aktif',
                'is_online'      => 0,
                'last_active_at' => null,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            // // Dept User
            [
                'username'       => 'dept PROD',
                'password'       => password_hash('dept123', PASSWORD_DEFAULT),
                'fullname'       => 'Sulaiman',
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
