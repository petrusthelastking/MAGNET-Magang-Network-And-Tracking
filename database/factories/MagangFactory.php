<?php

namespace Database\Factories;

use App\Models\Magang;
use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Magang>
 */
class MagangFactory extends Factory
{
    protected $model = Magang::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->jobTitle(),
            'deskripsi' => $this->faker->paragraph(),
            'persyaratan' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['buka', 'tutup']),
            'lokasi' => $this->faker->address(),
            'perusahaan_id' => fn() => Perusahaan::inRandomOrder()->value('id')
        ];
    }
}
