<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BadgePencapaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        // Retrieve category IDs
        $kategoriIds = DB::table('kategori_pencapaians')->pluck('id', 'nama_pencapaian');
        $rows = [
            [
                'nama_pencapaian'          => 'Juara Kelas',
                'syarat'                   => json_encode(['rapot_min' => 90]),
                'kategori_pencapaian_id'   => $kategoriIds['Akademik'] ?? 1,
                'gambar'                   => 'juara_kelas.png',
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
            [
                'nama_pencapaian'          => 'Atlet Berprestasi',
                'syarat'                   => json_encode(['olahraga_event' => 'Peringkat 1']),
                'kategori_pencapaian_id'   => $kategoriIds['Olahraga'] ?? 1,
                'gambar'                   => 'atlet_berprestasi.png',
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
            [
                'nama_pencapaian'          => 'Seniman Muda',
                'syarat'                   => json_encode(['karya' => 'Pameran']),
                'kategori_pencapaian_id'   => $kategoriIds['Seni'] ?? 1,
                'gambar'                   => 'seniman_muda.png',
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
            [
                'nama_pencapaian'          => 'Aktivis Organisasi',
                'syarat'                   => json_encode(['organisasi' => 'Ketua']),
                'kategori_pencapaian_id'   => $kategoriIds['Organisasi'] ?? 1,
                'gambar'                   => 'aktivis_organisasi.png',
                'created_at'               => $now,
                'updated_at'               => $now,
            ],
        ];
        DB::table('badge_pencapaians')->insert($rows);
    }
}
