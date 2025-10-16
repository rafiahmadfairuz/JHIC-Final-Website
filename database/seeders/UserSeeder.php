<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

/**
 * Seeder for the `users` and `profiles` tables.
 *
 * The seeder performs several tasks:
 *  1. Creates three administrative accounts (admin utama, admin perpus
 *     dan admin bkk).  These accounts can be used by the site
 *     administrators.
 *  2. Creates twelve teacher (guru) accounts.  The email addresses
 *     intentionally look like plausible Gmail addresses and can be
 *     adjusted by the developer if necessary.  All teachers share
 *     the same default password for simplicity ("password").
 *  3. Iterates over each class (kelas) and generates exactly ten
 *     student accounts (siswa) per class.  Each student receives a
 *     corresponding profile with a reference to their class.  Names
 *     and emails are generated using the Faker library configured for
 *     Indonesian locale.
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        // 1. Admins
        $admins = [
            [
                'nama_lengkap' => 'Admin Utama',
                'email'        => 'admin@gmail.test',
                'password'     => Hash::make('1234'),
                'role'         => 'admin_utama',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_lengkap' => 'Admin Perpustakaan',
                'email'        => 'perpus@gmail.test',
                'password'     => Hash::make('1234'),
                'role'         => 'admin_perpus',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_lengkap' => 'Admin BKK',
                'email'        => 'bkk@gmail.test',
                'password'     => Hash::make('1234'),
                'role'         => 'admin_bkk',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ];
        DB::table('users')->insert($admins);

        // 2. Guru
        $guruList = [
            ['Rafi Prasetyo', 'rafirpl@gmail.com'],
            ['Siti Aminah', 'siti.aminah@gmail.com'],
            ['Dewi Kartika', 'dewi.kartika@gmail.com'],
            ['Budi Santoso', 'budi.santoso@gmail.com'],
        ];
        $guruRecords = [];
        foreach ($guruList as $guru) {
            $guruRecords[] = [
                'nama_lengkap' => $guru[0],
                'email'        => $guru[1],
                'password'     => Hash::make('1234'),
                'role'         => 'guru',
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }
        DB::table('users')->insert($guruRecords);

        // 3. Akun demo siswa & alumni paten
        $demoUsers = [
            [
                'nama_lengkap' => 'Demo Siswa RPL',
                'email'        => 'demo.siswa@gmail.test',
                'password'     => Hash::make('1234'),
                'role'         => 'siswa',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_lengkap' => 'Demo Alumni',
                'email'        => 'demo.alumni@gmail.test',
                'password'     => Hash::make('1234'),
                'role'         => 'alumni',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ];
        DB::table('users')->insert($demoUsers);

        // 4. Generate siswa Faker per kelas (original logic kamu)
        $faker = Faker::create('id_ID');
        $kelasCollection = DB::table('kelas')->get();

        foreach ($kelasCollection as $kelas) {
            for ($i = 1; $i <= 10; $i++) {
                $studentName = $faker->name();
                $emailSlug   = Str::slug($studentName);
                $email       = $emailSlug . $kelas->id . $i . '@gmail.test';

                DB::table('users')->insert([
                    'nama_lengkap' => $studentName,
                    'email'        => $email,
                    'password'     => Hash::make('1234'),
                    'role'         => 'siswa',
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ]);
            }
        }
    }
}
