<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now  = now();
        $rows = [
            ['nama' => 'PT Maju Jaya',          'alamat' => 'Jl. Merdeka No.1', 'jenis_perusahaan' => 'pt', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'CV Sinar Dunia',        'alamat' => 'Jl. Mawar No.2',   'jenis_perusahaan' => 'cv', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'UD Bina Sejahtera',      'alamat' => 'Jl. Melati No.3',  'jenis_perusahaan' => 'ud', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('perusahaans')->insert($rows);
    }
}
