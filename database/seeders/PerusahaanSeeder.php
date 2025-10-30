<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $perusahaanNames = [
            'PT Maju Jaya',
            'CV Sinar Dunia',
            'UD Bina Sejahtera',
            'PT Prima Karya',
            'CV Harapan Bangsa'
        ];

        foreach ($perusahaanNames as $name) {
            $email = Str::of($name)->lower()->replace(' ', '') . '@gmail.com';
            $user = User::create([
                'nama_lengkap' => $name,
                'email' => $email,
                'password' => Hash::make('password123'),
                'role' => 'perusahaan'
            ]);

            DB::table('perusahaans')->insert([
                'nama' => $name,
                'perusahaan_id' => $user->id,
                'alamat' => 'Jl. Contoh No.' . rand(1, 100),
                'jenis_perusahaan' => ['pt', 'cv', 'ud'][rand(0, 2)],
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }
}
