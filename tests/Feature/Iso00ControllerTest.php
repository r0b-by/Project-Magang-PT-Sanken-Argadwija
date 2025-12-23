<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\TestDatabaseTrait;

class Iso00ControllerTest extends CIUnitTestCase
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

    public function testStoreWithoutFileReturnsError()
    {
        $result = $this->withSession([
            'isLoggedIn' => true,
            'user_id' => 1,
            'role' => 'admin'
        ])->post('/iso00/store', [
            'kode_dokumen' => 'DOK-002'
        ]);

        $this->assertTrue($result->isRedirect());
    }

    public function testViewFileNotFound()
    {
        $result = $this->withSession([
            'isLoggedIn' => true,
            'role' => 'admin'
        ])->get('/iso00/view/999999');

        $result->assertStatus(404);
    }

    public function testUpdateAuthorizationDeniedForNonUploader()
    {
        // Existing doc uploaded_by = 1, but session user is dept (id 2)
        $result = $this->withSession([
            'isLoggedIn' => true,
            'user_id' => 2,
            'role' => 'dept'
        ])->call('post', 'iso00/update/1', [
            'kode_dokumen' => 'DOK-001-EDIT'
        ]);

        $this->assertTrue($result->isRedirect());
    }
}
