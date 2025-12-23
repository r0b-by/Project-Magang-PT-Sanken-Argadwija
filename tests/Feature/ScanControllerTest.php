<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\TestDatabaseTrait;

class ScanControllerTest extends CIUnitTestCase
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

    public function testProcessNotFound()
    {
        $result = $this->call('post', 'scan/process', [
            'barcode' => 'NOT-FOUND'
        ]);

        $this->assertTrue($result->isRedirect());
    }

    public function testFileReturnsPdfHeaders()
    {
        $result = $this->call('get', 'scan/file/1');

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertStringContainsString('application/pdf', $result->getHeaderLine('Content-Type'));
    }
}
