<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TokoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now     = now();
        $tokoIds = DB::table('tokos')->pluck('id')->toArray();
        $teachers = DB::table('users')->where('role', 'siswa')->pluck('id')->toArray();
        $rows    = [];
        $tCount  = count($teachers);
        foreach ($tokoIds as $index => $tokoId) {
            // assign four teachers per store by rotating through teacher list
            for ($i = 0; $i < 4; $i++) {
                $teacherId = $teachers[($index * 4 + $i) % $tCount];
                $rows[] = [
                    'toko_id'    => $tokoId,
                    'user_id'    => $teacherId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        DB::table('toko_users')->insert($rows);
    }
}
