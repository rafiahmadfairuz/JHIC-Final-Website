<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now  = now();
        $rows = [
            ['nama_toko' => 'Koperasi Siswa', 'deskripsi' => 'Toko koperasi yang menjual kebutuhan siswa', 'created_at' => $now, 'updated_at' => $now],
            ['nama_toko' => 'JHI Mart',      'deskripsi' => 'Mini market sekolah', 'created_at' => $now, 'updated_at' => $now],
            ['nama_toko' => 'Toko Kreatif',  'deskripsi' => 'Produk kreatif siswa', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('tokos')->insert($rows);
    }
}
