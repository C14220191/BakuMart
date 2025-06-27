<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $startDate = Carbon::now('Asia/Jakarta')->subMonths(5)->startOfDay();

        for ($i = 0; $i < 20; $i++) {
            $orderDate = $startDate->copy()->addDays($i * rand(5, 7));
            $formattedDate = $orderDate->format('Y-m-d H:i:s');

            DB::table('orders')->insert([
                'user_id' => rand(1, 2),
                'order_date' => $formattedDate,
                'status' => 'paid_cash',
                'total' => 0,
                'payment_proof' => null,
                'created_at' => $formattedDate,
                'updated_at' => $formattedDate,
            ]);
        }
    }
}
