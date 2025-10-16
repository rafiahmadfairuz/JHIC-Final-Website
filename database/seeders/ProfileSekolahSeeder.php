<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProfileSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only insert if profile does not already exist
        if (DB::table('profile_sekolahs')->count() > 0) {
            return;
        }
        $now          = now();
        $statsSiswa   = DB::table('users')->where('role', 'siswa')->count();
        $statsJurusan = DB::table('jurusans')->count();
        $statsAlumni  = DB::table('alumnis')->count();
        // Number of achievements earned (badges awarded)
        $statsPrestasi = DB::table('badge_pencapaian_siswas')->count();
        DB::table('profile_sekolahs')->insert([
            'banner_img'    => 't.png',
            'stats_siswa'   => $statsSiswa,
            'stats_jurusan' => $statsJurusan,
            'stats_alumni'  => $statsAlumni,
            'stats_prestasi' => $statsPrestasi,
            'link_video'    => 'https://youtu.be/vBuSonqhXdU?si=nzfx6Ukqnez8H5wI',
            'created_at'    => $now,
            'updated_at'    => $now,
        ]);
    }
}
