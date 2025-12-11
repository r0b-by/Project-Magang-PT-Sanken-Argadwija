<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration {
    
    public function up() {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'unsigned'       => true,
            ],

            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],

            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],

            'fullname' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true
            ],

            'nomor_holder' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
                'comment'    => 'contoh 1 atau 1a'
            ],

            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],

            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'dept'],
                'default'    => 'dept'
            ],

            'status_akun' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'nonaktif'],
                'default'    => 'aktif'
            ],

            'is_online' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],

            'last_active_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down() {
        $this->forge->dropTable('users');
    }
}
