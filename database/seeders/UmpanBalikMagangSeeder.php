<?php

namespace Database\Seeders;

use App\Models\UmpanBalikMagang;
use Illuminate\Database\Seeder;

class UmpanBalikMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UmpanBalikMagang::factory()->count(100)->create();
    }
}
