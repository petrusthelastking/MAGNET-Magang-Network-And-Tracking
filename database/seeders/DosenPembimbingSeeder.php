<?php

namespace Database\Seeders;

use App\Models\DosenPembimbing;
use Illuminate\Database\Seeder;

class DosenPembimbingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DosenPembimbing::factory()->count(30)->create();
    }
}
