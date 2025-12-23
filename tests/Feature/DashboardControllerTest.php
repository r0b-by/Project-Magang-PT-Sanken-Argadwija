<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\TestDatabaseTrait;

class DashboardControllerTest extends CIUnitTestCase
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

    public function testAdminDashboardAccessible()
    {
        try {
            $result = $this->withSession([
                'isLoggedIn' => true,
                'role' => 'admin',
                'user_id' => 1,
                'username' => 'admin',
            ])->get('/dashboard/admin');
        } catch (\Throwable $e) {
            $this->fail('Exception during request: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return;
        }

        // Diagnostic - make assertions more informative
        $this->assertNotNull($result, 'Response object is null');
        $this->assertIsObject($result, 'Result is not an object; type: ' . gettype($result));

        // Use TestResponse assertions
        $result->assertStatus(200);
        $result->assertOK();
    }

    public function testDeptDashboardAccessible()
    {
        try {
            $result = $this->withSession([
                'isLoggedIn' => true,
                'role' => 'dept',
                'user_id' => 2,
            ])->get('/dashboard/dept');
        } catch (\Throwable $e) {
            $this->fail('Exception during request: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return;
        }

        $this->assertNotNull($result, 'Response object is null for dept');
        $this->assertIsObject($result, 'Result is not an object; type: ' . gettype($result));

        $result->assertStatus(200);
        $result->assertOK();
    }
}
