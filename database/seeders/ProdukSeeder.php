<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now        = now();
        $kategoriIds = DB::table('kategori_produks')->pluck('id')->toArray();
        $tokoIds    = DB::table('tokos')->pluck('id')->toArray();
        $rows       = [];
        foreach ($tokoIds as $tokoId) {
            for ($i = 1; $i <= 3; $i++) {
                $rows[] = [
                    'nama'       => 'Produk ' . $i . ' Toko ' . $tokoId,
                    'toko_id'    => $tokoId,
                    'harga'      => rand(10000, 100000),
                    'stok'       => rand(5, 50),
                    'gambar'     => 'produk' . $i . '.png',
                    'kategori_id' => $kategoriIds[array_rand($kategoriIds)],
                    'deskripsi'  => 'Deskripsi produk ' . $i . ' dari toko ' . $tokoId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        DB::table('produks')->insert($rows);
    }
}
