<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BadgePencapaianSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now        = now();
        $badgeIds   = DB::table('badge_pencapaians')->pluck('id')->toArray();
        $students   = DB::table('users')->where('role', 'siswa')->pluck('id')->toArray();
        $rows       = [];
        $totalStu   = count($students);
        foreach ($badgeIds as $badgeId) {
            // Determine how many students get this badge (~10%)
            $count = max(1, intval($totalStu * 0.10));
            // Randomly pick unique student IDs
            $selected = (array) array_rand(array_flip($students), $count);
            foreach ($selected as $siswaId) {
                $rows[] = [
                    'badge_pencapaian_id' => $badgeId,
                    'siswa_id'            => $siswaId,
                    'created_at'          => $now,
                    'updated_at'          => $now,
                ];
            }
        }
        $chunks = array_chunk($rows, 500);
        foreach ($chunks as $chunk) {
            DB::table('badge_pencapaian_siswas')->insert($chunk);
        }
    }
}
