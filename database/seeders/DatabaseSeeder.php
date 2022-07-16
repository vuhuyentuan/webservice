<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminTableSeeder::class);
    }
}

class AdminTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'role' => '1',
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@service.com',
                'password' => Hash::make('admin@123'),
                'recovery_password' => 'admin@123',
            ],
        ]);
    }
}
