<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Map of major name to number of classes per tingkat
        $config = [
            'Teknik Logistik'                 => 2,
            'Teknik Instalasi Tenaga Listrik' => 9,
            'Teknik Permesinan'               => 9,
            'Teknik Pengelasan'               => 1,
            'Rekayasa Perangkat Lunak'        => 5,
        ];

        $now = now();
        foreach ($config as $namaJurusan => $jumlahKelas) {
            $jurusanId = DB::table('jurusans')
                ->where('nama_jurusan', $namaJurusan)
                ->value('id');
            // Ensure the jurusan exists before seeding classes
            if (!$jurusanId) {
                continue;
            }
            // Tingkat 10, 11, 12
            foreach ([10, 11, 12] as $tingkat) {
                for ($i = 1; $i <= $jumlahKelas; $i++) {
                    DB::table('kelas')->insert([
                        'tingkat'       => (string) $tingkat,
                        'jurusan_id'    => $jurusanId,
                        'urutan_kelas'  => (string) $i,
                        'created_at'    => $now,
                        'updated_at'    => $now,
                    ]);
                }
            }
        }
    }
}
