<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIsoAccessHoldersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'unsigned'       => true
            ],
            'user_id' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'dokumen_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'comment'  => 'Mengambil id dari iso_00'
            ],
            'holder_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'comment'    => 'Contoh: 1A, 2B, 3C'
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

        // foreign keys
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dokumen_id', 'iso_00', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('iso_access_holders');
    }

    public function down()
    {
        $this->forge->dropTable('iso_access_holders');
    }
}
