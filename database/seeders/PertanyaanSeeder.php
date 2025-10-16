<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PertanyaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now  = now();
        $rows = [
            [
                'judul'     => 'Bagaimana cara mendaftar?',
                'jawaban'   => 'Kunjungi laman pendaftaran dan isi formulir yang tersedia.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'judul'     => 'Kapan tahun ajaran baru dimulai?',
                'jawaban'   => 'Tahun ajaran baru dimulai setiap bulan Juli.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'judul'     => 'Apakah ada program beasiswa?',
                'jawaban'   => 'Ya, informasi beasiswa dapat diperoleh di bagian kesiswaan.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'judul'     => 'Bagaimana cara menghubungi guru?',
                'jawaban'   => 'Hubungi guru melalui platform e‑learning atau datang ke ruang guru.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'judul'     => 'Apakah ada kegiatan ekstrakurikuler?',
                'jawaban'   => 'Sekolah menyediakan berbagai macam ekstrakurikuler seperti pramuka, olahraga dan seni.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        DB::table('pertanyaans')->insert($rows);
    }
}
