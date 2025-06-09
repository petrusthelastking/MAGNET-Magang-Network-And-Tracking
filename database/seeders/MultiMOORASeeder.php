<?php

namespace Database\Seeders;

use App\Helpers\DecisionMaking\RecommendationSystem;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MultiMOORASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataMahasiswa = Mahasiswa::all();
        foreach ($dataMahasiswa as $mahasiswa) {
            $multiMooraObj = new RecommendationSystem($mahasiswa);
            $multiMooraObj->runRecommendationSystem();
            echo $mahasiswa->nama . " success to get recommendation system" . PHP_EOL;
        }
    }
}
