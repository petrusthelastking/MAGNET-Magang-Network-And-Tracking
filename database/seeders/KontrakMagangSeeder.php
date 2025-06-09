<?php

namespace Database\Seeders;

use App\Models\KontrakMagang;
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
        KontrakMagang::factory()->count(12)->create();
    }
}
