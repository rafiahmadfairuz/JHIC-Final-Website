<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $jurusans = [
            ['nama_jurusan' => 'Teknik Logistik',                    'gambar_jurusan' => 'j5.png', 'created_at' => $now, 'updated_at' => $now],
            ['nama_jurusan' => 'Teknik Instalasi Tenaga Listrik',    'gambar_jurusan' => 'j1.png', 'created_at' => $now, 'updated_at' => $now],
            ['nama_jurusan' => 'Teknik Permesinan',                  'gambar_jurusan' => 'j4.png', 'created_at' => $now, 'updated_at' => $now],
            ['nama_jurusan' => 'Teknik Pengelasan',                  'gambar_jurusan' => 'j2.png', 'created_at' => $now, 'updated_at' => $now],
            ['nama_jurusan' => 'Rekayasa Perangkat Lunak',           'gambar_jurusan' => 'j3.png', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('jurusans')->insert($jurusans);
    }
}
