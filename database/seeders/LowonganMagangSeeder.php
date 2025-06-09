<?php

namespace Database\Seeders;

use App\Models\LowonganMagang;
use Illuminate\Database\Seeder;

class LowonganMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LowonganMagang::factory()->count(20)->create();
    }
}
