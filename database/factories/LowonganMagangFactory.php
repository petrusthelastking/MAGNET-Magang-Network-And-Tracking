<?php

namespace Database\Factories;

use App\Models\LokasiMagang;
use App\Models\LowonganMagang;
use App\Models\Pekerjaan;
use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LowonganMagang>
 */
class LowonganMagangFactory extends Factory
{
    protected $model = LowonganMagang::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->jobTitle(),
            'kuota' => $this->faker->numberBetween(1, 50),
            'pekerjaan_id' => fn() => Pekerjaan::inRandomOrder()->value('id'),
            'deskripsi' => $this->faker->paragraph(),
            'persyaratan' => $this->faker->paragraph(),
            'jenis_magang' => $this->faker->randomElement(['berbayar', 'tidak berbayar']),
            'open_remote' => $this->faker->randomElement(['ya', 'tidak']),
            'status' => $this->faker->randomElement(['buka', 'tutup']),
            'lokasi_magang_id' => fn() => LokasiMagang::inRandomOrder()->value('id'),
            'perusahaan_id' => fn() => Perusahaan::inRandomOrder()->value('id')
        ];
    }
}
