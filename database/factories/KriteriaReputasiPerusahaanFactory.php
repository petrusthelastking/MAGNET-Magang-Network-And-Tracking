<?php

namespace Database\Factories;

use App\Helpers\ROC;
use App\Models\KriteriaReputasiPerusahaan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KriteriaReputasiPerusahaan>
 */
class KriteriaReputasiPerusahaanFactory extends Factory
{
    protected $model = KriteriaReputasiPerusahaan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rank = $this->faker->numberBetween(1, 6);

        return [
            'reputasi_perusahaan' => $this->faker->randomElement(['<1','1<= x <2','2<= x <3','3<= x <4','4<= x <5']),
            'rank' => $rank,
            'bobot' => ROC::getWeight($rank, 6)
        ];
    }
}
