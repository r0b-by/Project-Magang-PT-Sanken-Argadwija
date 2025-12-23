<?php

namespace Tests\Support;

trait TestDatabaseTrait
{
    protected function createTestTables()
    {
        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();
        $prefix = $db->getPrefix();

        // users
        if (! $db->tableExists('users')) {
            $fields = [
                'id'          => ['type' => 'INTEGER', 'constraint' => 11, 'auto_increment' => true],
                'username'    => ['type' => 'TEXT'],
                'password'    => ['type' => 'TEXT'],
                'fullname'    => ['type' => 'TEXT'],
                'role'        => ['type' => 'TEXT'],
                'foto'        => ['type' => 'TEXT'],
                'status_akun' => ['type' => 'TEXT'],
                'is_online'   => ['type' => 'INTEGER', 'constraint' => 1, 'default' => 0],
                'last_active_at' => ['type' => 'TEXT', 'null' => true],
                'created_at' => ['type' => 'TEXT', 'null' => true],
                'updated_at' => ['type' => 'TEXT', 'null' => true],
            ];
            $forge->addField($fields);
            $forge->addKey('id', true);
            $forge->createTable('users');
        }

        // iso_00
        if (! $db->tableExists('iso_00')) {
            $fields = [
                'id'                     => ['type' => 'INTEGER', 'constraint' => 11, 'auto_increment' => true],
                'kode_dokumen'           => ['type' => 'TEXT'],
                'nama_dokumen_internal'  => ['type' => 'TEXT'],
                'nama_file'              => ['type' => 'TEXT', 'null' => true],
                'file_path'              => ['type' => 'TEXT', 'null' => true],
                'file_size'              => ['type' => 'INTEGER', 'null' => true],
                'mime_type'              => ['type' => 'TEXT', 'null' => true],
                'uploaded_by'            => ['type' => 'INTEGER', 'null' => true],
                'uploaded_at'            => ['type' => 'TEXT', 'null' => true],
                'barcode'                => ['type' => 'TEXT', 'null' => true],
                'revision_no'            => ['type' => 'INTEGER', 'default' => 0],
                'status'                 => ['type' => 'TEXT', 'null' => true],
                'created_at'             => ['type' => 'TEXT', 'null' => true],
                'updated_at'             => ['type' => 'TEXT', 'null' => true],
            ];
            $forge->addField($fields);
            $forge->addKey('id', true);
            $forge->createTable('iso_00');
        }

        // iso_001 (history)
        if (! $db->tableExists('iso_001')) {
            $fields = [
                'id'        => ['type' => 'INTEGER', 'constraint' => 11, 'auto_increment' => true],
                'iso00_id'  => ['type' => 'INTEGER'],
                'nama_file' => ['type' => 'TEXT'],
                'file_path' => ['type' => 'TEXT'],
                'mime_type' => ['type' => 'TEXT'],
                'uploaded_by' => ['type' => 'INTEGER'],
                'uploaded_at' => ['type' => 'TEXT'],
            ];
            $forge->addField($fields);
            $forge->addKey('id', true);
            $forge->createTable('iso_001');
        }

        // iso_access_holders
        if (! $db->tableExists('iso_access_holders')) {
            $fields = [
                'id'          => ['type' => 'INTEGER', 'constraint' => 11, 'auto_increment' => true],
                'holder_code' => ['type' => 'TEXT'],
                'dokumen_id'  => ['type' => 'INTEGER', 'null' => true],
                'created_at'  => ['type' => 'TEXT', 'null' => true],
                'updated_at'  => ['type' => 'TEXT', 'null' => true],
            ];
            $forge->addField($fields);
            $forge->addKey('id', true);
            $forge->createTable('iso_access_holders');
        }

        // iso_access_documents
        if (! $db->tableExists('iso_access_documents')) {
            $fields = [
                'id'        => ['type' => 'INTEGER', 'constraint' => 11, 'auto_increment' => true],
                'holder_id' => ['type' => 'INTEGER'],
                'iso00_id'  => ['type' => 'INTEGER'],
                'created_at'=> ['type' => 'TEXT', 'null' => true],
            ];
            $forge->addField($fields);
            $forge->addKey('id', true);
            $forge->createTable('iso_access_documents');
        }

        // iso_access_users
        if (! $db->tableExists('iso_access_users')) {
            $fields = [
                'id'        => ['type' => 'INTEGER', 'constraint' => 11, 'auto_increment' => true],
                'holder_id' => ['type' => 'INTEGER'],
                'user_id'   => ['type' => 'INTEGER'],
                'created_at'=> ['type' => 'TEXT', 'null' => true],
                'updated_at'=> ['type' => 'TEXT', 'null' => true],
            ];
            $forge->addField($fields);
            $forge->addKey('id', true);
            $forge->createTable('iso_access_users');
        }

        // activity_logs (plural, per model)
        if (! $db->tableExists('activity_logs')) {
            $fields = [
                'id' => ['type' => 'INTEGER', 'constraint' => 11, 'auto_increment' => true],
                'user_id' => ['type' => 'INTEGER'],
                'username' => ['type' => 'TEXT'],
                'fullname' => ['type' => 'TEXT', 'null' => true],
                'role' => ['type' => 'TEXT', 'null' => true],
                'activity' => ['type' => 'TEXT', 'null' => true],
                'ip_address' => ['type' => 'TEXT', 'null' => true],
                'created_at' => ['type' => 'TEXT', 'null' => true],
            ];
            $forge->addField($fields);
            $forge->addKey('id', true);
            $forge->createTable('activity_logs');
        }

        // Seed minimal data
        $db->table('users')->insertBatch([
            [
                'id' => 1,
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'fullname' => 'Admin User',
                'role' => 'admin',
                'foto' => 'default.png',
                'status_akun' => 'aktif',
                'is_online' => 0,
            ],
            [
                'id' => 2,
                'username' => 'dept',
                'password' => password_hash('dept123', PASSWORD_DEFAULT),
                'fullname' => 'Dept User',
                'role' => 'dept',
                'foto' => 'default.png',
                'status_akun' => 'aktif',
                'is_online' => 0,
            ],
        ]);

        $db->table('iso_00')->insert([
            'id' => 1,
            'kode_dokumen' => 'DOK-001',
            'nama_dokumen_internal' => 'Dokumen Uji',
            'nama_file' => 'sample.pdf',
            'file_path' => 'uploads/iso/masters/sample.pdf',
            'file_size' => 1234,
            'mime_type' => 'application/pdf',
            'uploaded_by' => 1,
            'uploaded_at' => date('Y-m-d H:i:s'),
            'status' => 'save',
        ]);

        // create test upload folders
        if (! is_dir(WRITEPATH . 'uploads/iso/masters/')) {
            mkdir(WRITEPATH . 'uploads/iso/masters/', 0775, true);
        }

        // create a sample PDF file
        $samplePdf = WRITEPATH . 'uploads/iso/masters/sample.pdf';
        if (! file_exists($samplePdf)) {
            file_put_contents($samplePdf, "%PDF-1.4\n%\u00e2\u00e3\u00cf\u00d3\n");
        }
    }

    protected function dropTestTables()
    {
        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();
        $prefix = $db->getPrefix();

        foreach ([
            'activity_logs',
            'iso_access_users',
            'iso_access_documents',
            'iso_access_holders',
            'iso_001',
            'iso_00',
            'users',
        ] as $table) {
            if ($db->tableExists($table)) {
                $forge->dropTable($table);
            }
        }

        // cleanup sample file
        $samplePdf = WRITEPATH . 'uploads/iso/masters/sample.pdf';
        if (file_exists($samplePdf)) {
            @unlink($samplePdf);
        }
    }
}
