<?php 

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIsoAccessHoldersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'holder_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => false,
                'unique'     => true, // UNIQUE otomatis buat index
                'comment'    => 'Kode holder, contoh: 1A, 2B',
            ],
            'dokumen_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'Relasi ke tabel iso_00',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Primary key
        $this->forge->addKey('id', true);

        // Index tambahan
        $this->forge->addKey('dokumen_id');

        // Foreign key
        $this->forge->addForeignKey(
            'dokumen_id',
            'iso_00',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->createTable('iso_access_holders', true);
    }

    public function down()
    {
        $this->forge->dropTable('iso_access_holders', true);
    }
}
