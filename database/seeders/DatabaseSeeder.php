<?php

namespace Database\Seeders;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $faker = FakerFactory::create();
        $faker->seed(123);

        $this->call([
            MahasiswaSeeder::class,
            DosenPembimbingSeeder::class,
            AdminSeeder::class,
            BidangIndustriSeeder::class,
            PekerjaanSeeder::class,
            LokasiMagangSeeder::class,
            PerusahaanSeeder::class,
            LowonganMagangSeeder::class,
            KontrakMagangSeeder::class,
            LogMagangSeeder::class,
            UlasanMagangSeeder::class,
            UmpanBalikMagangSeeder::class,
            BerkasPengajuanMagangSeeder::class,
            FormPengajuanMagangSeeder::class,
            PreferensiMahasiswaSeeder::class,
        ]);
    }
}
