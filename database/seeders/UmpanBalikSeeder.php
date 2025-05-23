<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UmpanBalikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('umpan_balik')->insert([
            [
                'kontrak_magang_id' => 4,
                'komentar' => 'Mahasiswa menunjukkan dedikasi tinggi dan kemampuan analitis yang baik. Sangat recommend untuk program selanjutnya.',
                'tanggal' => '2023-12-01'
            ],
            [
                'kontrak_magang_id' => 5,
                'komentar' => 'Perlu peningkatan dalam komunikasi tim, namun secara teknis sudah memenuhi standar perusahaan.',
                'tanggal' => '2023-11-01'
            ],
            [
                'kontrak_magang_id' => 1,
                'komentar' => 'Mahasiswa cepat beradaptasi dengan environment kerja. Troubleshooting skills berkembang dengan baik.',
                'tanggal' => '2024-05-01'
            ],
        ]);
    }
}
