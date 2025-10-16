<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KursusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now        = now();
        $mapels     = DB::table('mapels')->orderBy('id')->get();
        $guruIds    = DB::table('users')->where('role', 'guru')->orderBy('id')->pluck('id')->toArray();
        $kelasList  = DB::table('kelas')->get();

        $kursusRows = [];
        foreach ($mapels as $index => $mapel) {
            $guruId = $guruIds[$index] ?? $guruIds[array_rand($guruIds)];
            foreach ($kelasList as $kelas) {
                $kursusRows[] = [
                    'nama_kursus' => $mapel->nama_mapel . ' - Kelas ' . $kelas->tingkat . $kelas->urutan_kelas,
                    'mapel_id'    => $mapel->id,
                    'guru_id'     => $guruId,
                    'kelas_id'    => $kelas->id,
                    'isi_kursus'  => 'Materi kursus untuk ' . $mapel->nama_mapel . ' kelas ' . $kelas->tingkat . $kelas->urutan_kelas,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ];
            }
        }
        // Insert courses in chunks to avoid memory issues on very large datasets
        $chunks = array_chunk($kursusRows, 500);
        foreach ($chunks as $chunk) {
            DB::table('kursuses')->insert($chunk);
        }
    }
}
