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
            'departement' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama_file' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'upload_dokumen' => [
                'type' => 'LONGBLOB',
                'null' => true,
            ],
            'tanggal_efektif' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'halaman_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'comment' => 'Contoh: 1-8'
            ],
            'ruang_lingkup' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Contoh: Ongoing QS'
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
                'null' => false,
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
                'null' => false
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

        // Foreign Key
        $this->forge->addForeignKey('uploaded_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('updated_by', 'users', 'id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('iso_00');
    }

    public function down()
    {
        $this->forge->dropTable('iso_00');
    }
}
