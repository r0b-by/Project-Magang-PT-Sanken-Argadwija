<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\TestDatabaseTrait;

class BarcodeControllerTest extends CIUnitTestCase
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

    public function testGenerateSetsBarcode()
    {
        $result = $this->withSession([
            'isLoggedIn' => true,
            'role' => 'admin'
        ])->call('get', 'barcode/generate/1');

        $this->assertTrue($result->isRedirect());

        $db = \Config\Database::connect();
        $row = $db->table($db->getPrefix() . 'iso_00')->where('id', 1)->get()->getRowArray();
        $this->assertNotEmpty($row['barcode']);
    }

    public function testPrintWithoutBarcodeRedirects()
    {
        // Insert doc without barcode
        $db = \Config\Database::connect();
        $db->table($db->getPrefix() . 'iso_00')->insert([
            'id' => 2,
            'kode_dokumen' => 'DOK-002',
            'nama_dokumen_internal' => 'No QR',
            'status' => 'save',
        ]);

        $result = $this->withSession([
            'isLoggedIn' => true,
            'role' => 'admin'
        ])->call('get', 'barcode/print/2');

        $this->assertTrue($result->isRedirect());
    }
}
