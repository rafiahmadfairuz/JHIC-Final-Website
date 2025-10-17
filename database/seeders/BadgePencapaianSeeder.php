<?php

namespace Database\Seeders;

use App\Models\BadgePencapaian;
use Illuminate\Database\Seeder;
use App\Models\KategoriPencapaian;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BadgePencapaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = KategoriPencapaian::all();

        // Daftar badge contoh (10 total)
        $badges = [
            [
                'nama' => 'Rajin Nugas I',
                'tipe' => 'tugas_selesai',
                'syarat' => ['tipe' => 'tugas_selesai', 'jumlah' => 1],
                'gambar' => 'badges/rajin-nugas-1.png',
            ],
            [
                'nama' => 'Rajin Nugas II',
                'tipe' => 'tugas_selesai',
                'syarat' => ['tipe' => 'tugas_selesai', 'jumlah' => 3],
                'gambar' => 'badges/rajin-nugas-2.png',
            ],
            [
                'nama' => 'Rajin Nugas III',
                'tipe' => 'tugas_selesai',
                'syarat' => ['tipe' => 'tugas_selesai', 'jumlah' => 5],
                'gambar' => 'badges/rajin-nugas-3.png',
            ],
            [
                'nama' => 'Nilai Rapot Bagus I',
                'tipe' => 'rapot_bagus',
                'syarat' => ['tipe' => 'rapot_bagus', 'min_rata' => 70],
                'gambar' => 'badges/rapot-bagus-1.png',
            ],
            [
                'nama' => 'Nilai Rapot Bagus II',
                'tipe' => 'rapot_bagus',
                'syarat' => ['tipe' => 'rapot_bagus', 'min_rata' => 80],
                'gambar' => 'badges/rapot-bagus-2.png',
            ],
            [
                'nama' => 'Nilai Rapot Bagus III',
                'tipe' => 'rapot_bagus',
                'syarat' => ['tipe' => 'rapot_bagus', 'min_rata' => 90],
                'gambar' => 'badges/rapot-bagus-3.png',
            ],
            [
                'nama' => 'Sikap Baik I',
                'tipe' => 'perilaku_baik',
                'syarat' => ['tipe' => 'perilaku_baik', 'minimal_poin' => 10],
                'gambar' => 'badges/perilaku-1.png',
            ],
            [
                'nama' => 'Sikap Baik II',
                'tipe' => 'perilaku_baik',
                'syarat' => ['tipe' => 'perilaku_baik', 'minimal_poin' => 20],
                'gambar' => 'badges/perilaku-2.png',
            ],
            [
                'nama' => 'Sikap Baik III',
                'tipe' => 'perilaku_baik',
                'syarat' => ['tipe' => 'perilaku_baik', 'minimal_poin' => 50],
                'gambar' => 'badges/perilaku-3.png',
            ],
            [
                'nama' => 'All Rounder',
                'tipe' => 'rapot_bagus',
                'syarat' => ['tipe' => 'rapot_bagus', 'min_rata' => 85],
                'gambar' => 'badges/allrounder.png',
            ],
        ];

        foreach ($badges as $b) {
            BadgePencapaian::create([
                'nama_pencapaian' => $b['nama'],
                'syarat' => $b['syarat'], // kolom sudah di-cast ke array
                'kategori_pencapaian_id' => $categories->random()->id,
                'gambar' => $b['gambar'],
            ]);
        }
    }
}
