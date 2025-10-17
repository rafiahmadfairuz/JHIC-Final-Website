<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JawabanSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run(): void
    {
        // $now         = now();
        // $maxStudents = 5; // number of students per class to answer each question
        // $soalList    = DB::table('soals')
        //     ->join('tugas', 'soals.tugas_id', '=', 'tugas.id')
        //     ->join('kursuses', 'tugas.kursus_id', '=', 'kursuses.id')
        //     ->select('soals.*', 'kursuses.kelas_id')
        //     ->get();

        // $rows = [];
        // foreach ($soalList as $soal) {
        //     // Find up to $maxStudents students from the associated class
        //     $studentIds = DB::table('profiles')
        //         ->where('kelas_id', $soal->kelas_id)
        //         ->pluck('user_id')
        //         ->take($maxStudents)
        //         ->toArray();
        //     foreach ($studentIds as $siswaId) {
        //         // Random answer among A–D
        //         $opsi = ['A', 'B', 'C', 'D'];
        //         $jawaban = $opsi[array_rand($opsi)];
        //         $nilai   = ($jawaban === $soal->jawaban_benar) ? 10 : 0;
        //         $rows[] = [
        //             'soal_id'         => $soal->id,
        //             'siswa_id'        => $siswaId,
        //             'jawaban_dipilih' => $jawaban,
        //             'nilai'           => $nilai,
        //             'created_at'      => $now,
        //             'updated_at'      => $now,
        //         ];
        //     }
        // }
        // $chunks = array_chunk($rows, 500);
        // foreach ($chunks as $chunk) {
        //     DB::table('jawaban_siswas')->insert($chunk);
        // }
    }
}
