<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;


class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now      = now();
        $faker    = Faker::create('id_ID');
        $jurusans = DB::table('jurusans')->pluck('nama_jurusan')->toArray();
        $rows     = [];
        for ($i = 0; $i < 10; $i++) {
            $rows[] = [
                'nama'         => $faker->name(),
                'jurusan'      => $jurusans[array_rand($jurusans)],
                'alumni_tahun' => (string) rand(2018, 2024),
                'keterangan'   => $faker->sentence(12),
                'rating'       => rand(3, 5),
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }
        DB::table('alumnis')->insert($rows);
    }
}
