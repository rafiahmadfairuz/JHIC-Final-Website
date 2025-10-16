<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $orders   = DB::table('orders')->get();
        $products = DB::table('produks')->get();
        $rows     = [];
        foreach ($orders as $order) {
            $numItems = rand(1, 3);
            $total    = 0;
            for ($i = 0; $i < $numItems; $i++) {
                $product = $products->random();
                $qty     = rand(1, 5);
                $total  += $product->harga * $qty;
                $rows[] = [
                    'order_id' => $order->id,
                    'produk_id'=> $product->id,
                    'qty'      => $qty,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            // Update the order total
            DB::table('orders')
                ->where('id', $order->id)
                ->update(['total' => $total]);
        }
        DB::table('order_items')->insert($rows);
    }
}
