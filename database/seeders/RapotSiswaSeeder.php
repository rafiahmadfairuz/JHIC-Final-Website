<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RapotSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now        = now();
        $students   = DB::table('users')->where('role', 'siswa')->pluck('id')->toArray();
        $mapelIds   = DB::table('mapels')->pluck('id')->toArray();
        $rows       = [];
        foreach ($students as $siswaId) {
            foreach ($mapelIds as $mapelId) {
                $rows[] = [
                    'mapel_id'   => $mapelId,
                    'siswa_id'   => $siswaId,
                    'nilai'      => rand(60, 100),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        $chunks = array_chunk($rows, 500);
        foreach ($chunks as $chunk) {
            DB::table('rapot_siswas')->insert($chunk);
        }
    }
}
