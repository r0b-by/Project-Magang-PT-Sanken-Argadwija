<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivityLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],

            'user_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true
            ],

            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 50
            ],

            'fullname' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true
            ],

            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'dept']
            ],

            'activity' => [
                'type'       => 'ENUM',
                'constraint' => ['login', 'logout']
            ],

            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true
            ],

            'created_at' => [
                'type' => 'DATETIME'
            ]
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey(
            'user_id',
            'users',
            'id',
            'SET NULL',
            'SET NULL'
        );

        $this->forge->createTable('activity_logs', true);
    }

    public function down()
    {
        $this->forge->dropTable('activity_logs', true);
    }
}
