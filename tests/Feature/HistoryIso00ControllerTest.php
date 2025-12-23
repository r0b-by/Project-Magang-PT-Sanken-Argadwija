<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\TestDatabaseTrait;

class HistoryIso00ControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;
    use TestDatabaseTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->createTestTables();
    }

    public function tearDown(): void
    {
        $this->dropTestTables();
        parent::tearDown();
    }

    public function testIndexDeniedForUnauthorised()
    {
        $result = $this->withSession([
            'isLoggedIn' => true,
            'role' => 'dept',
            'user_id' => 2
        ])->call('get', 'iso00/history/1');

        $this->assertTrue($result->isRedirect());
    }

    public function testDeleteHistoryAsAdminRemovesRecord()
    {
        $db = \Config\Database::connect();
        $prefix = $db->getPrefix();

        // create a history record
        $db->table($prefix . 'iso_001')->insert([
            'id' => 1,
            'iso00_id' => 1,
            'nama_file' => 'sample.pdf',
            'file_path' => 'uploads/iso/masters/sample.pdf',
            'mime_type' => 'application/pdf',
            'uploaded_by' => 1,
            'uploaded_at' => date('Y-m-d H:i:s')
        ]);

        $file = WRITEPATH . 'uploads/iso/masters/sample.pdf';
        if (! file_exists($file)) {
            file_put_contents($file, "%PDF-1.4\n");
        }

        $result = $this->withSession([
            'isLoggedIn' => true,
            'role' => 'admin',
        ])->call('get', 'iso00/history/delete/1');

        $this->assertTrue($result->isRedirect());

        $row = $db->table($prefix . 'iso_001')->where('id', 1)->get()->getRowArray();
        $this->assertEmpty($row);
    }
}
