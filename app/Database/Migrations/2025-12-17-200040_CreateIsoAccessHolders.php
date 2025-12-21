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
                'unique'     => true,
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

        $this->forge->addKey('id', true);

        $this->forge->createTable('iso_access_holders', true);
    }

    public function down()
    {
        $this->forge->dropTable('iso_access_holders', true);
    }
}
