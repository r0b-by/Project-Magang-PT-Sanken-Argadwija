<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIso00Table extends Migration
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
             * IDENTITAS DOKUMEN
             * ===================================================*/
            'kode_dokumen' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,
                'comment'    => 'Kode dokumen final (contoh: VD-QS001)'
            ],

            /* =====================================================
             * DEPARTEMEN (SNAPSHOT + RELASI)
             * ===================================================*/
            'kode_dept' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'comment'    => 'Snapshot kode departemen saat upload'
            ],

            'department_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'Relasi ke departments.id (boleh NULL)'
            ],

            /* =====================================================
             * INFO DOKUMEN
             * ===================================================*/
            'nama_dokumen_internal' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            // ❌ DEPRECATED (disimpan untuk kompatibilitas lama)
            'upload_dokumen' => [
                'type'    => 'LONGBLOB',
                'null'    => true,
                'comment' => 'DEPRECATED - jangan digunakan'
            ],

            'file_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'writable/uploads/iso/masters'
            ],

            'file_size' => [
                'type'    => 'INT',
                'comment' => 'Ukuran file (byte)'
            ],

            'mime_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'application/pdf'
            ],

            /* =====================================================
             * METADATA ISO
             * ===================================================*/
            'tanggal_efektif' => [
                'type' => 'DATE',
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
             * STATUS & REVISI
             * ===================================================*/
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['unsave', 'save', 'revisi'],
                'default'    => 'unsave',
                'comment'    => 'unsave=draft, save=final, revisi=perubahan',
            ],

            'revision_no' => [
                'type'       => 'INT',
                'default'    => 0,
                'comment'    => 'Jumlah revisi yang pernah dibuat'
            ],

            'is_locked' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => '1=dokumen terkunci'
            ],

            /* =====================================================
             * INFO USER
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
                'constraint' => 50
            ],

            'uploader_foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'uploaded_at' => [
                'type' => 'DATETIME',
            ],

            'updated_by' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'barcode' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);

        /* =====================================================
         * INDEX & FOREIGN KEY
         * ===================================================*/
        $this->forge->addKey('id', true);
        //$this->forge->addKey('kode_dokumen');
        $this->forge->addKey('department_id');

        // FK USERS
        $this->forge->addForeignKey(
            'uploaded_by',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'updated_by',
            'users',
            'id',
            'SET NULL',
            'CASCADE'
        );

        // FK DEPARTMENTS (boleh NULL)
        $this->forge->addForeignKey(
            'department_id',
            'departments',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->createTable('iso_00', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('iso_00', true);
    }
}
