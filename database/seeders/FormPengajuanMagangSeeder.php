<?php

namespace Database\Seeders;

use App\Models\FormPengajuanMagang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormPengajuanMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FormPengajuanMagang::factory()->count(15)->create();
    }
}
