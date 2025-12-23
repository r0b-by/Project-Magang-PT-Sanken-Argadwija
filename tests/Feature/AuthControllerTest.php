<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\TestDatabaseTrait;

class AuthControllerTest extends CIUnitTestCase
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

    public function testLoginProcessSuccess()
    {
        $result = $this->call('post', 'login/process', [
            'username' => 'admin',
            'password' => 'admin123'
        ]);

        $this->assertTrue($result->isRedirect());
    }

    public function testLogoutClearsSession()
    {
        $result = $this->withSession([
            'isLoggedIn' => true,
            'user_id' => 1,
            'username' => 'admin'
        ])->call('get', 'logout');

        $this->assertTrue($result->isRedirect());
    }
}
