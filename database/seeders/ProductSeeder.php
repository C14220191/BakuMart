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
                'admin_id' => 1, // Assuming admin_id is required and 1 is a valid admin ID
                'price' => 100.00,
                'stock' => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description for Product 2',
                'admin_id' => 1,
                'price' => 150.00,
                'stock' => 5,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 3',
                'description' => 'Description for Product 3',
                'admin_id' => 1,
                'price' => 200.00,
                'stock' => 20,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 4',
                'description' => 'Description for Product 4',
                'admin_id' => 1,
                'price' => 250.00,
                'stock' => 15,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 5',
                'description' => 'Description for Product 5',
                'admin_id' => 1,
                'price' => 300.00,
                'stock' => 8,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 6',
                'description' => 'Description for Product 6',
                'admin_id' => 1,
                'price' => 350.00,
                'stock' => 12,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 7',
                'description' => 'Description for Product 7',
                'admin_id' => 1,
                'price' => 400.00,
                'stock' => 7,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 8',
                'description' => 'Description for Product 8',
                'admin_id' => 1,
                'price' => 450.00,
                'stock' => 3,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 9',
                'description' => 'Description for Product 9',
                'admin_id' => 1,
                'price' => 500.00,
                'stock' => 6,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 10',
                'description' => 'Description for Product 10',
                'admin_id' => 1,
                'price' => 550.00,
                'stock' => 4,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Product 11',
                'description' => 'Description for Product 11',
                'admin_id' => 1,
                'price' => 600.00,
                'stock' => 9,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}
