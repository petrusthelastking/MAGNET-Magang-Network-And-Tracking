<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kriteria')->insert([
            [
                'nama_kriteria' => 'Teknologi Informasi',
                'nilai' => 0.9,
                'rank' => 1
            ],
            [
                'nama_kriteria' => 'Perbankan dan Keuangan',
                'nilai' => 0.8,
                'rank' => 2
            ],
            [
                'nama_kriteria' => 'Kesehatan',
                'nilai' => 0.85,
                'rank' => 3
            ],
            [
                'nama_kriteria' => 'Pendidikan',
                'nilai' => 0.7,
                'rank' => 4
            ],
            [
                'nama_kriteria' => 'Manufaktur',
                'nilai' => 0.75,
                'rank' => 5
            ],
            [
                'nama_kriteria' => 'Jakarta',
                'nilai' => 0.9,
                'rank' => 1
            ],
            [
                'nama_kriteria' => 'Bandung',
                'nilai' => 0.8,
                'rank' => 2
            ],
            [
                'nama_kriteria' => 'Surabaya',
                'nilai' => 0.75,
                'rank' => 3
            ],
            [
                'nama_kriteria' => 'Yogyakarta',
                'nilai' => 0.7,
                'rank' => 4
            ],
            [
                'nama_kriteria' => 'Reputasi Tinggi',
                'nilai' => 0.9,
                'rank' => 1
            ],
            [
                'nama_kriteria' => 'Reputasi Sedang',
                'nilai' => 0.7,
                'rank' => 2
            ],
            [
                'nama_kriteria' => 'Uang Saku Tinggi',
                'nilai' => 0.8,
                'rank' => 1
            ],
            [
                'nama_kriteria' => 'Uang Saku Sedang',
                'nilai' => 0.6,
                'rank' => 2
            ],
            [
                'nama_kriteria' => 'Remote Friendly',
                'nilai' => 0.85,
                'rank' => 1
            ],
            [
                'nama_kriteria' => 'On-site Only',
                'nilai' => 0.5,
                'rank' => 2
            ],
        ]);
    }
}
