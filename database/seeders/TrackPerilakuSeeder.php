<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TrackPerilakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now       = now();
        $students  = DB::table('users')->where('role', 'siswa')->pluck('id')->toArray();
        $teachers  = DB::table('users')->where('role', 'guru')->pluck('id')->toArray();
        $rows      = [];
        // Create 100 behavioural notes
        for ($i = 0; $i < 100; $i++) {
            $siswaId = $students[array_rand($students)];
            $guruId  = $teachers[array_rand($teachers)];
            $rows[] = [
                'siswa_id'   => $siswaId,
                'guru_id'    => $guruId,
                'catatan'    => 'Catatan perilaku ke-' . ($i + 1) . ' untuk siswa dengan ID ' . $siswaId,
                'tanggal'    => Carbon::now()->subDays(rand(0, 30))->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('track_perilakus')->insert($rows);
    }
}
