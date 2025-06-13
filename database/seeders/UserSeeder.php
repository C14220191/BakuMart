<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            [
                'name' => 'Jason Doe',
                'email' => 'admin123@gmail.com',
                'phone' => '1234567890',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ],
            [
                'name' => 'John Doe',
                'email' => 'jasonalexander778@gmail.com',
                'phone' => '0987654321',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]
        ]);
    }
}
