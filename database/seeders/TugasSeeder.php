<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $now         = now();
        $kursusList  = DB::table('kursuses')->get();
        $tugasRows   = [];
        foreach ($kursusList as $kursus) {
            for ($i = 1; $i <= 2; $i++) {
                $tugasRows[] = [
                    'kursus_id'         => $kursus->id,
                    'nama_tugas'        => 'Tugas ' . $i . ' ' . $kursus->nama_kursus,
                    'batas_pengumpulan' => Carbon::now()->addWeeks($i),
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ];
            }
        }
        $chunks = array_chunk($tugasRows, 500);
        foreach ($chunks as $chunk) {
            DB::table('tugas')->insert($chunk);
        }
    }
}
