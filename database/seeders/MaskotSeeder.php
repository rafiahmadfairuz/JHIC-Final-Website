<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MaskotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now  = now();
        $rows = [
            ['nama_maskot' => 'Dhini Mekarsari',    'jabatan' => 'Kepala Sekolah SMk Krian 1', 'gambar_maskot' => 'kepsek.png', 'created_at' => $now, 'updated_at' => $now],
            ['nama_maskot' => 'Si Tangguh',   'jabatan' => 'Maskot Olahraga', 'gambar_maskot' => 'tangguh.png', 'created_at' => $now, 'updated_at' => $now],
            ['nama_maskot' => 'Si Kreatif',   'jabatan' => 'Maskot Seni',     'gambar_maskot' => 'kreatif.png', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('maskots')->insert($rows);
    }
}
