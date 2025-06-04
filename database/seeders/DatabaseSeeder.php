<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            MahasiswaSeeder::class,
            DosenPembimbingSeeder::class,
            AdminSeeder::class,
            BidangIndustriSeeder::class,
            PekerjaanSeeder::class,
            LokasiMagangSeeder::class,
            PerusahaanSeeder::class,
            MagangSeeder::class,
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
