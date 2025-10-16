<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now   = now();
        $rows  = [
            ['nama' => 'Elektronik', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Pakaian',    'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Aksesoris',  'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('kategori_produks')->insert($rows);
    }
}
