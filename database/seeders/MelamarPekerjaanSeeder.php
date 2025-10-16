<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MelamarPekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now        = now();
        $jobs       = DB::table('pekerjaans')->pluck('id')->toArray();
        $students   = DB::table('users')->where('role', 'siswa')->pluck('id')->toArray();
        $statuses   = ['pending', 'diterima', 'ditolak'];
        $rows       = [];
        for ($i = 0; $i < 10; $i++) {
            $rows[] = [
                'pekerjaan_id'            => $jobs[array_rand($jobs)],
                'pelamar_id'              => $students[array_rand($students)],
                'berkas_yang_dibutuhkan'  => 'berkas' . ($i + 1) . '.pdf',
                'status'                  => $statuses[array_rand($statuses)],
                'created_at'              => $now,
                'updated_at'              => $now,
            ];
        }
        DB::table('melamar_pekerjaans')->insert($rows);
    }
}
