<?php 

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIsoAccessUsersTable extends Migration
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
                'null'     => false,
                'comment'  => 'Relasi ke iso_access_holders',
            ],
            'user_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => false,
                'comment'  => 'Relasi ke users',
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
        $this->forge->addKey('holder_id');
        $this->forge->addKey('user_id');

        // Unique key agar 1 user tidak dobel di 1 holder
        $this->forge->addUniqueKey(['holder_id', 'user_id']);

        // Foreign key
        $this->forge->addForeignKey(
            'holder_id',
            'iso_access_holders',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('iso_access_users', true);
    }

    public function down()
    {
        $this->forge->dropTable('iso_access_users', true);
    }
}
