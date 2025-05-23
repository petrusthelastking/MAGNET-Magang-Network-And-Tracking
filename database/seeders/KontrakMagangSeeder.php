<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KontrakMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kontrak_magang')->insert([
            [
                'mahasiswa_id' => 2,
                'dosen_id' => 1,
                'magang_id' => 1,
                'waktu_awal' => '2024-02-01 08:00:00',
                'waktu_akhir' => '2024-04-30 17:00:00'
            ],
            [
                'mahasiswa_id' => 5,
                'dosen_id' => 2,
                'magang_id' => 2,
                'waktu_awal' => '2024-03-01 08:00:00',
                'waktu_akhir' => '2024-05-31 17:00:00'
            ],
            [
                'mahasiswa_id' => 9,
                'dosen_id' => 3,
                'magang_id' => 3,
                'waktu_awal' => '2024-01-15 09:00:00',
                'waktu_akhir' => '2024-04-15 18:00:00'
            ],
            [
                'mahasiswa_id' => 3,
                'dosen_id' => 4,
                'magang_id' => 4,
                'waktu_awal' => '2023-09-01 08:30:00',
                'waktu_akhir' => '2023-11-30 17:30:00'
            ],
            [
                'mahasiswa_id' => 7,
                'dosen_id' => 5,
                'magang_id' => 7,
                'waktu_awal' => '2023-08-01 07:00:00',
                'waktu_akhir' => '2023-10-31 16:00:00'
            ],
        ]);
    }
}
