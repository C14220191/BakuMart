<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Product 1',
                'description' => 'Description for Product 1',
                'admin_id' => 1,
                'price' => 10000,
                'stock' => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description for Product 2',
                'admin_id' => 1,
                'price' => 15000,
                'stock' => 5,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 3',
                'description' => 'Description for Product 3',
                'admin_id' => 1,
                'price' => 20000,
                'stock' => 20,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 4',
                'description' => 'Description for Product 4',
                'admin_id' => 1,
                'price' => 25000,
                'stock' => 15,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 5',
                'description' => 'Description for Product 5',
                'admin_id' => 1,
                'price' => 30000,
                'stock' => 8,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 6',
                'description' => 'Description for Product 6',
                'admin_id' => 1,
                'price' => 35000,
                'stock' => 12,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 7',
                'description' => 'Description for Product 7',
                'admin_id' => 1,
                'price' => 40000,
                'stock' => 7,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 8',
                'description' => 'Description for Product 8',
                'admin_id' => 1,
                'price' => 45000,
                'stock' => 3,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 9',
                'description' => 'Description for Product 9',
                'admin_id' => 1,
                'price' => 50000,
                'stock' => 6,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 10',
                'description' => 'Description for Product 10',
                'admin_id' => 1,
                'price' => 55000,
                'stock' => 4,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 11',
                'description' => 'Description for Product 11',
                'admin_id' => 1,
                'price' => 60000,
                'stock' => 9,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}
