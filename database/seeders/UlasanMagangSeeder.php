<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UlasanMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ulasan_magang')->insert([
            [
                'kontrak_magang_id' => 4,
                'rating' => 5,
                'komentar' => 'Pengalaman magang yang sangat berharga. Tim sangat supportive dan memberikan learning experience yang berkualitas.'
            ],
            [
                'kontrak_magang_id' => 5,
                'rating' => 4,
                'komentar' => 'Magang di manufacturing sangat menantang. Banyak belajar tentang proses produksi yang efisien.'
            ],
            [
                'kontrak_magang_id' => 1,
                'rating' => 4,
                'komentar' => 'Mendapat exposure yang bagus di bidang IT. Mentor sangat berpengalaman dan sabar dalam membimbing.'
            ],
        ]);
    }
}
