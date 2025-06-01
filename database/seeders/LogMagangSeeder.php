<?php

namespace Database\Seeders;

use App\Models\LogMagang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LogMagang::factory()->count(100)->create();
    }
}
