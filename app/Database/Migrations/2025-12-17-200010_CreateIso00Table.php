<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIso00Table extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],

            'kode_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'unique' => true
            ],

            'nama_dokumen_internal' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            // ⬇️ TETAP DIPAKAI (nama asli file)
            'nama_file' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],

            // ❌ JANGAN DIHAPUS (agar backward compatible)
            // ❗ tapi JANGAN DIPAKAI LAGI
            'upload_dokumen' => [
                'type' => 'LONGBLOB',
                'null' => true,
                'comment' => 'DEPRECATED - jangan digunakan'
            ],

            // ✅ PATH FILE SEBENARNYA (PRIVATE)
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'comment' => 'writable/uploads/iso/masters'
            ],
            
            'file_size' => [
                'type' => 'INT',
                'comment' => 'Ukuran file (byte)'
            ],

            'mime_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => 'application/pdf'
            ],

            'tanggal_efektif' => [
                'type' => 'DATE',
            ],

            'halaman_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],

            'ruang_lingkup' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'tujuan' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'status' => [
                'type' => 'ENUM',
                'constraint' => ['save','non-save','revisi'],
                'default' => 'save',
            ],

            'uploaded_by' => [
                'type' => 'INT',
                'unsigned' => true,
            ],

            'uploader_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],

            'uploader_role' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],

            'uploader_foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'uploaded_at' => [
                'type' => 'DATETIME',
            ],

            'updated_by' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'barcode' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('uploaded_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('updated_by', 'users', 'id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('iso_00', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('iso_00', true);
    }
}
