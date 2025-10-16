<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now        = now();
        $tugasList  = DB::table('tugas')->get();
        $soalRows   = [];
        foreach ($tugasList as $tugas) {
            for ($i = 1; $i <= 3; $i++) {
                // Choose a correct answer in a round‑robin fashion
                $answers = ['A', 'B', 'C', 'D'];
                $correct = $answers[($i - 1) % count($answers)];
                $soalRows[] = [
                    'tugas_id'      => $tugas->id,
                    'pertanyaan'    => 'Pertanyaan ' . $i . ' untuk ' . $tugas->nama_tugas,
                    'opsi_a'        => 'Pilihan A',
                    'opsi_b'        => 'Pilihan B',
                    'opsi_c'        => 'Pilihan C',
                    'opsi_d'        => 'Pilihan D',
                    'jawaban_benar' => $correct,
                    'skor'          => 10,
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ];
            }
        }
        $chunks = array_chunk($soalRows, 500);
        foreach ($chunks as $chunk) {
            DB::table('soals')->insert($chunk);
        }
    }
}
