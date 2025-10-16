<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now        = now();
        $adminBkkId = DB::table('users')->where('role', 'admin_bkk')->value('id');
        $perusahaanIds = DB::table('perusahaans')->pluck('id')->toArray();
        $statuses   = ['aktif', 'tutup'];
        $rows       = [];
        foreach ($perusahaanIds as $idx => $perusahaanId) {
            $rows[] = [
                'admin_bkk_id'  => $adminBkkId,
                'perusahaan_id' => $perusahaanId,
                'judul'         => 'Lowongan ' . ($idx + 1),
                'deskripsi'     => 'Deskripsi pekerjaan ke-' . ($idx + 1),
                'syarat'        => 'Syarat pekerjaan ke-' . ($idx + 1),
                'batas'         => Carbon::now()->addMonths(rand(1, 3))->toDateString(),
                'lokasi'        => 'Surabaya',
                'poster'        => 'poster' . ($idx + 1) . '.png',
                'status'        => $statuses[array_rand($statuses)],
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }
        DB::table('pekerjaans')->insert($rows);
    }
}
