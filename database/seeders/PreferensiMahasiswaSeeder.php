<?php

namespace Database\Seeders;

use App\Models\PreferensiMahasiswa;
use Illuminate\Database\Seeder;

class PreferensiMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PreferensiMahasiswa::factory()->count(200)->create();
    }
}
