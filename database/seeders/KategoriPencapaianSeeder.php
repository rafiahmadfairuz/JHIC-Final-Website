<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriPencapaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now   = now();
        $rows  = [
            ['nama_pencapaian' => 'Akademik',     'created_at' => $now, 'updated_at' => $now],
            ['nama_pencapaian' => 'Olahraga',      'created_at' => $now, 'updated_at' => $now],
            ['nama_pencapaian' => 'Seni',          'created_at' => $now, 'updated_at' => $now],
            ['nama_pencapaian' => 'Organisasi',    'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('kategori_pencapaians')->insert($rows);
    }
}
