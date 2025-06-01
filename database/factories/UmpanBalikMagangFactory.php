<?php

namespace Database\Factories;

use App\Models\KontrakMagang;
use App\Models\UmpanBalikMagang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UmpanBalikMagang>
 */
class UmpanBalikMagangFactory extends Factory
{
    protected $model = UmpanBalikMagang::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kontrak_magang_id' => fn() => KontrakMagang::inRandomOrder()->value('id'),
            'komentar' => $this->faker->sentence(3),
            'tanggal' => $this->faker->dateTimeBetween('-1 years', '+1 years')->format('Y-m-d'),
        ];
    }
}
