<?php

namespace Database\Factories;

use App\Helpers\DecisionMaking\ROC;
use App\Models\KriteriaLokasiMagang;
use App\Models\LokasiMagang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KriteriaLokasiMagang>
 */
class KriteriaLokasiMagangFactory extends Factory
{
    protected $model = KriteriaLokasiMagang::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rank = $this->faker->numberBetween(1, 6);

        return [
            'lokasi_magang_id' => fn() => LokasiMagang::inRandomOrder()->value('id'),
            'rank' => $rank,
            'bobot' => ROC::getWeight($rank, 6)
        ];
    }
}
