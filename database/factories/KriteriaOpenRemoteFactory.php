<?php

namespace Database\Factories;

use App\Helpers\DecisionMaking\ROC;
use App\Models\KriteriaOpenRemote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KriteriaOpenRemote>
 */
class KriteriaOpenRemoteFactory extends Factory
{
    protected $model = KriteriaOpenRemote::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rank = $this->faker->numberBetween(1, 6);

        return [
            'open_remote' => $this->faker->randomElement(['ya', 'tidak']),
            'rank' => $rank,
            'bobot' => ROC::getWeight($rank, 6)
        ];
    }
}
