<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDepartmentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            /* =====================================================
             * PRIMARY KEY
             * ===================================================*/
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            /* =====================================================
             * KODE DEPARTEMEN
             * ===================================================*/
            'kode_dept' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'unique'     => true,
                'comment'    => 'Kode unik departemen'
            ],

            /* =====================================================
             * NAMA DEPARTEMEN
             * ===================================================*/
            'nama_dept' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'comment'    => 'Nama departemen'
            ],

            /* =====================================================
             * STATUS AKTIF / NONAKTIF
             * ===================================================*/
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
                'comment'    => 'Status departemen'
            ],

            /* =====================================================
             * AUDIT TRAIL
             * ===================================================*/
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
        $this->forge->createTable('departments', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('departments', true);
    }
}
