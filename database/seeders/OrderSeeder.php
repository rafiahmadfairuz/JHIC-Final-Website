<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now      = now();
        $students = DB::table('users')->where('role', 'siswa')->pluck('id')->toArray();
        $rows     = [];
        $statuses = ['pending', 'selesai', 'batal'];
        // Create 20 orders
        for ($i = 0; $i < 20; $i++) {
            $pembeliId = $students[array_rand($students)];
            $rows[] = [
                'pembeli_id' => $pembeliId,
                'total'      => 0.00, // updated later in OrderItemSeeder
                'status'     => $statuses[array_rand($statuses)],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('orders')->insert($rows);
    }
}
