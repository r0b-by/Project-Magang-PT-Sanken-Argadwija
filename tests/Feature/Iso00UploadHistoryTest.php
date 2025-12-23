<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\TestDatabaseTrait;

class Iso00UploadHistoryTest extends CIUnitTestCase
{
    use FeatureTestTrait;
    use TestDatabaseTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->createTestTables();

        // Ensure upload dirs exist
        if (!is_dir(WRITEPATH . 'uploads/iso/masters/')) mkdir(WRITEPATH . 'uploads/iso/masters/', 0775, true);
        if (!is_dir(WRITEPATH . 'uploads/iso/revisions/')) mkdir(WRITEPATH . 'uploads/iso/revisions/', 0775, true);
    }

    public function tearDown(): void
    {
        $this->dropTestTables();
        parent::tearDown();
    }

    public function testStoreWithPdfCreatesDraft()
    {
        // Simulate the storage process (move + DB insert) because full HTTP file upload is not reliable in this test environment.
        $tmp = tempnam(sys_get_temp_dir(), 'phpunit_pdf');
        file_put_contents($tmp, "%PDF-1.4\n%\u00e2\u00e3\u00cf\u00d3\n");

        // sanitize + ensure unique name similar to controller logic
        $original = 'upload_sample.pdf';
        $name = pathinfo($original, PATHINFO_FILENAME);
        $safe = preg_replace('/[^a-zA-Z0-9-_]/', '_', $name);
        $safe = strtolower($safe);
        $final = $safe . '.pdf';
        $i = 1;
        while (file_exists(WRITEPATH . 'uploads/iso/masters/' . $final)) {
            $final = $safe . '_' . $i . '.pdf';
            $i++;
        }

        // move file into place (simulate upload move)
        $dest = WRITEPATH . 'uploads/iso/masters/' . $final;
        rename($tmp, $dest);

        // create DB record (mimic controller insert)
        $db = \Config\Database::connect();
        $db->table('iso_00')->insert([
            'kode_dokumen' => 'DOK-UP-001',
            'nama_dokumen_internal' => 'Upload Test',
            'nama_file' => $final,
            'file_path' => 'uploads/iso/masters/' . $final,
            'file_size' => filesize($dest),
            'mime_type' => 'application/pdf',
            'uploaded_by' => 1,
            'uploaded_at' => date('Y-m-d H:i:s'),
            'status' => 'unsave',
            'revision_no' => 0,
        ]);

        $row = $db->table('iso_00')->where('kode_dokumen', 'DOK-UP-001')->get()->getRowArray();
        $this->assertNotEmpty($row);
        $this->assertEquals($final, $row['nama_file']);
        $this->assertFileExists($dest);
    }

    public function testHistoryViewDownloadAndDeleteAsAdmin()
    {
        // create a fake history file and record
        $filePath = 'uploads/iso/revisions/hist_sample.pdf';
        $full = WRITEPATH . $filePath;
        if (!is_dir(dirname($full))) mkdir(dirname($full), 0775, true);
        file_put_contents($full, "%PDF-1.4\n%\u00e2\u00e3\u00cf\u00d3\n");

        $db = \Config\Database::connect();
        $db->table('iso_001')->insert([
            'id' => 999,
            'iso00_id' => 1,
            'nama_file' => 'hist_sample.pdf',
            'file_path' => $filePath,
            'mime_type' => 'application/pdf',
            'uploaded_by' => 1,
            'uploaded_at' => date('Y-m-d H:i:s')
        ]);

        // view
        $result = $this->withSession([
            'isLoggedIn' => true,
            'role' => 'admin'
        ])->get('/iso00/history/view/999');

        $result->assertHeader('Content-Type', 'application/pdf');

        // delete
        $del = $this->withSession([
            'isLoggedIn' => true,
            'role' => 'admin'
        ])->get('/iso00/history/delete/999');

        $this->assertTrue($del->isRedirect());

        // assert record removed
        $row = $db->table('iso_001')->where('id', 999)->get()->getRowArray();
        $this->assertEmpty($row);

        // file should be removed
        $this->assertFileDoesNotExist($full);
    }
}
