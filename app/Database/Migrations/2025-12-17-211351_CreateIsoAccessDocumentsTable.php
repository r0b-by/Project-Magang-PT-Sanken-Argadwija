<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIsoAccessDocumentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'holder_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'iso00_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Primary key
        $this->forge->addKey('id', true);

        // ✅ BATASAN UTAMA: 1 HOLDER = 1 DOKUMEN
        $this->forge->addUniqueKey('holder_id');

        // Foreign key ke holder
        $this->forge->addForeignKey(
            'holder_id',
            'iso_access_holders',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Foreign key ke dokumen ISO
        $this->forge->addForeignKey(
            'iso00_id',
            'iso_00',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('iso_access_documents', true);
    }

    public function down()
    {
        $this->forge->dropTable('iso_access_documents', true);
    }
}
