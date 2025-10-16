<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run(): void
    {
        $now   = now();
        $names = [
            'Rafi Prasetyo',
            'Siti Aminah',
            'Dewi Kartika',
            'Budi Santoso',
            'Mega Wibowo',
            'Ahmad Fajar',
            'Putri Ningsih',
            'Ridwan Hakim',
            'Intan Lestari',
            'Teguh Wijaya',
            'Hana Rahmawati',
            'Agus Supriyadi',
        ];
        $jabatan = [
            'Guru Matematika',
            'Guru Bahasa Indonesia',
            'Guru Bahasa Inggris',
            'Guru Fisika',
            'Guru Kimia',
            'Guru Biologi',
            'Guru Sejarah',
            'Guru Geografi',
            'Guru Ekonomi',
            'Guru Seni Budaya',
            'Guru Olahraga',
            'Guru Prakarya',
        ];
        $rows = [];
        foreach ($names as $i => $name) {
            $rows[] = [
                'nama_guru'    => $name,
                'guru_img'     => ($i + 1) . '.png',
                'jabatan_guru' => $jabatan[$i] ?? 'Guru',
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }
        DB::table('gurus')->insert($rows);
    }
}
