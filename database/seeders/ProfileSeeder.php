<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $classes = Kelas::all()->sortBy('id');
        $students = User::where('role', 'siswa')->orderBy('id')->get();
        $studentIndex = 0;
        foreach ($classes as $kelas) {
            // fetch 10 students for this class
            $classStudents = $students->slice($studentIndex, 10);
            foreach ($classStudents as $user) {
                Profile::firstOrCreate([
                    'user_id' => $user->id,
                ], [
                    'nama_lengkap' => $user->nama_lengkap,
                    'foto'         => null,
                    'kelas_id'     => $kelas->id,
                    'angkatan'     => null,
                    'alamat'       => fake()->address(),
                ]);
            }
            $studentIndex += 10;
        }
        // Assign profiles for alumni
        $alumniUsers = User::where('role', 'alumni')->get();
        foreach ($alumniUsers as $user) {
            Profile::firstOrCreate([
                'user_id' => $user->id,
            ], [
                'nama_lengkap' => $user->nama_lengkap,
                'foto'         => null,
                'kelas_id'     => null,
                'angkatan'     => (string) fake()->numberBetween(date('Y') - 10, date('Y') - 1),
                'alamat'       => fake()->address(),
            ]);
        }
    }
}
