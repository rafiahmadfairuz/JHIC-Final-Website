<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\KelasSeeder;
use Database\Seeders\JurusanSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            JurusanSeeder::class,
            KelasSeeder::class,
            UserSeeder::class,
            ProfileSeeder::class,
            SertifikatSeeder::class,
            MapelSeeder::class,
            KursusSeeder::class,
            TugasSeeder::class,
            SoalSeeder::class,
            JawabanSiswaSeeder::class,
            RapotSiswaSeeder::class,
            KategoriPencapaianSeeder::class,
            BadgePencapaianSeeder::class,
            BadgePencapaianSiswaSeeder::class,
            TrackPerilakuSeeder::class,
            KategoriProdukSeeder::class,
            TokoSeeder::class,
            ProdukSeeder::class,
            TokoUserSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            PerusahaanSeeder::class,
            PekerjaanSeeder::class,
            MelamarPekerjaanSeeder::class,
            ProfileSekolahSeeder::class,
            GuruSeeder::class,
            PertanyaanSeeder::class,
            MaskotSeeder::class,
            AlumniSeeder::class,
        ]);
    }
}
