<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIso001Table extends Migration
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
                'auto_increment' => true
            ],

            /* =====================================================
             * RELASI MASTER & DEPARTEMEN (SNAPSHOT)
             * ===================================================*/
            'iso00_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => false,
                'comment'  => 'Relasi ke iso_00 (master dokumen)'
            ],

            'department_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'Relasi ke departments.id (boleh NULL)'
            ],

            'kode_dept' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
                'comment'    => 'Snapshot kode departemen saat revisi'
            ],

            'nama_dept' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'comment'    => 'Snapshot nama departemen saat revisi'
            ],

            /* =====================================================
             * INFORMASI REVISI
             * ===================================================*/
            'versi' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
                'comment'    => 'Rev-1, Rev-2, dst'
            ],

            'revision_note' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            /* =====================================================
             * SNAPSHOT DATA ISO_00
             * ===================================================*/
            'kode_dokumen' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],

            'nama_dokumen_internal' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'file_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'writable/uploads/iso/revisions'
            ],

            'file_size' => [
                'type' => 'INT',
                'null' => true,
            ],

            'mime_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],

            'tanggal_efektif' => [
                'type' => 'DATE',
                'null' => true,
            ],

            'halaman_dokumen' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],

            'ruang_lingkup' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'tujuan' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            /* =====================================================
             * STATUS REVISI
             * ===================================================*/
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['unsave', 'save', 'revisi'],
                'default'    => 'revisi',
                'comment'    => 'Status revisi dokumen'
            ],

            /* =====================================================
             * INFO USER SAAT REVISI
             * ===================================================*/
            'uploaded_by' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'uploader_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'uploader_role' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],

            'uploaded_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        /* =====================================================
         * INDEX & CONSTRAINT
         * ===================================================*/
        $this->forge->addKey('id', true);
        $this->forge->addKey('iso00_id');
        $this->forge->addKey('department_id');
        $this->forge->addUniqueKey(['iso00_id', 'versi']);

        /* =====================================================
         * FOREIGN KEY
         * ===================================================*/
        $this->forge->addForeignKey(
            'iso00_id',
            'iso_00',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'department_id',
            'departments',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'uploaded_by',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('iso_001', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('iso_001', true);
    }
}
