<?php

namespace Database\Factories;

use App\Helpers\ROC;
use App\Models\Kriteria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kriteria>
 */
class KriteriaFactory extends Factory
{
    protected $model = Kriteria::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rank = $this->faker->numberBetween(1, 5);

        return [
            'nama_kriteria' => $this->faker->randomElement([
                'skil',
                'bidang industri',
                'open remote',
                'lokasi',
                'uang saku'
            ]),
            'nilai' => $this->faker->word(),
            'nilai_numerik' => ROC::getWeight($rank, 5),
            'rank' => $rank
        ];
    }
}
