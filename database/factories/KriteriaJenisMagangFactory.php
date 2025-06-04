<?php

namespace Database\Factories;

use App\Helpers\ROC;
use App\Models\KriteriaJenisMagang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KriteriaJenisMagang>
 */
class KriteriaJenisMagangFactory extends Factory
{
    protected $model = KriteriaJenisMagang::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rank = $this->faker->numberBetween(1, 6);

        return [
            'jenis_magang' => $this->faker->randomElement(['berbayar', 'tidak berbayar']),
            'rank' => $rank,
            'bobot' => ROC::getWeight($rank, 6)
        ];
    }
}
