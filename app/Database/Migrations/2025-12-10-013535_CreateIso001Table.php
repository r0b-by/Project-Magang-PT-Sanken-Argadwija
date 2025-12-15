<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIso001Table extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],

            // Relasi ke iso_00
            'iso00_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            // Versi revisi
            'versi' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'comment'    => 'Rev-1, Rev-2, dst'
            ],

            // === MIRROR DARI ISO_00 ===
            'kode_dokumen' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],

            'nama_dokumen_internal' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'upload_dokumen' => [
                'type' => 'LONGBLOB',
                'null' => true,
            ],

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

            // Status dokumen SAAT itu
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['save','non-save','revisi'],
                'default'    => 'revisi',
            ],

            // Info uploader
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
            ],

            'barcode' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        // FK
        $this->forge->addForeignKey('iso00_id', 'iso_00', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('uploaded_by', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('iso_001');
    }

    public function down()
    {
        $this->forge->dropTable('iso_001');
    }
}
