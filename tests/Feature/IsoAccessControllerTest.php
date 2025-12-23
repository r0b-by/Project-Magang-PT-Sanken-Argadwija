<?php

use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;
use Tests\Support\TestDatabaseTrait;

class IsoAccessControllerTest extends CIUnitTestCase
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

    public function testIndexDeniedForNonAdmin()
    {
        $result = $this->withSession([
            'isLoggedIn' => true,
            'role'       => 'dept',
        ])->call('get', 'access');

        $this->assertTrue($result->isRedirect());
    }

    public function testIndexAllowedForAdmin()
    {
        $result = $this->withSession([
            'isLoggedIn' => true,
            'role'       => 'admin',
        ])->get('/access');

        $result->assertOK();
        $result->assertStatus(200);
    }

    public function testStoreHolderCreatesRecord()
    {
        $result = $this->withSession([
            'isLoggedIn' => true,
            'role' => 'admin',
        ])->call('post', 'access/store-holder', [
            'holder_code' => 'H001'
        ]);

        $this->assertTrue($result->isRedirect());

        $db = \Config\Database::connect();
        $row = $db->table($db->getPrefix() . 'iso_access_holders')->get()->getRowArray();
        $this->assertNotEmpty($row);
    }
}
