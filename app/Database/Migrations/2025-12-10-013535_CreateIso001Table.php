<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIso0001Table extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'iso00_id' => [  // relasi ke dokumen asli
                'type' => 'INT',
                'unsigned' => true,
            ],
            'kode_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'nama_file' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'upload_dokumen' => [
                'type' => 'LONGBLOB',
                'null' => true,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['save','revisi'],
                'default' => 'revisi',
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
            'uploaded_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'barcode' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('iso00_id', 'iso_00', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('uploaded_by', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('iso_001');
    }

    public function down()
    {
        $this->forge->dropTable('iso_001');
    }
}
