<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $mapels = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Fisika',
            'Kimia',
            'Biologi',
            'Sejarah',
            'Geografi',
            'Ekonomi',
            'Seni Budaya',
            'Olahraga',
            'Prakarya',
        ];
        $rows = [];
        foreach ($mapels as $nama) {
            $rows[] = [
                'nama_mapel' => $nama,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('mapels')->insert($rows);
    }
}
