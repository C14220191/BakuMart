<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $orders = DB::table('orders')->get();

        foreach ($orders as $order) {
            $total = 0;
            for ($i = 0; $i < rand(1, 3); $i++) {
                $productId = rand(1, 11);
                $product = DB::table('products')->find($productId);
                $quantity = rand(1, 3);
                $price = $product->price * $quantity;
                $total += $price;

                DB::table('order_items')->insert([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $price,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->created_at,
                ]);
            }

            DB::table('orders')->where('id', $order->id)->update([
                'total' => $total
            ]);
        }
    }
}
