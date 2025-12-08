<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('Iso00Seeder');
        $this->call('Iso001Seeder');
    }
}
