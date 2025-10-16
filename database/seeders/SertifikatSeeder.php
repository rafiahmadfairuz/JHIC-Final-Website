<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SertifikatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now         = now();
        $percentage  = 0.25; // 25% of students
        $profileIds  = DB::table('profiles')->pluck('id')->toArray();
        $selectedCount = max(1, intval(count($profileIds) * $percentage));
        $selectedIds   = (array) array_rand(array_flip($profileIds), $selectedCount);
        $rows = [];
        $index = 1;
        foreach ($selectedIds as $profileId) {
            $rows[] = [
                'profile_id'    => $profileId,
                'judul_prestasi' => 'Sertifikat Prestasi #' . $index,
                'file_sertif'   => 'sertifikat' . $index . '.pdf',
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
            $index++;
        }
        DB::table('sertifikat')->insert($rows);
    }
}
