<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LokasiMagang;

class LokasiMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            'Area Malang Raya',
            'Luar area Malang Raya (dalam Jawa Timur)',
            'Luar provinsi Jawa Timur',
            'Luar negeri'
        ];

        foreach ($locations as $loc) {
            LokasiMagang::create([
                'kategori_lokasi' => $loc
            ]);
        }
    }
}
