<?php

namespace Database\Seeders;

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
                'nama_kriteria' => 'open remote',
                'nilai' => 'ya',
                'nilai_numerik' => 0.45666666666667,
                'rank' => 1
            ],
            [
                'nama_kriteria' => 'skil',
                'nilai' => 'frontend web developer',
                'nilai_numerik' => 0.25666666666667,
                'rank' => 2
            ],
            [
                'nama_kriteria' => 'bidang industri',
                'nilai' => 'Kesehatan',
                'nilai_numerik' => 0.15666666666667,
                'rank' => 3
            ],
            [
                'nama_kriteria' => 'lokasi',
                'nilai' => 'area malang raya',
                'nilai_numerik' => 0.09,
                'rank' => 4
            ],
            [
                'nama_kriteria' => 'uang saku',
                'nilai' => 'paid',
                'nilai_numerik' => 0.04,
                'rank' => 5
            ],
                        [
                'nama_kriteria' => 'open remote',
                'nilai' => 'tidak',
                'nilai_numerik' => 0.15666666666667,
                'rank' => 3
            ],
            [
                'nama_kriteria' => 'skil',
                'nilai' => 'ui/ux designer',
                'nilai_numerik' => 0.45666666666667,
                'rank' => 1
            ],
            [
                'nama_kriteria' => 'bidang industri',
                'nilai' => 'Pendidikan',
                'nilai_numerik' => 0.09,
                'rank' => 4
            ],
            [
                'nama_kriteria' => 'lokasi',
                'nilai' => 'area malang raya',
                'nilai_numerik' => 0.25666666666667,
                'rank' => 2
            ],
            [
                'nama_kriteria' => 'uang saku',
                'nilai' => 'unpaid',
                'nilai_numerik' => 0.04,
                'rank' => 5
            ],
        ]);
    }
}
