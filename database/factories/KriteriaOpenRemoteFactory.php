<?php

namespace Database\Factories;

use App\Enums\DecisionMakingEnum;
use App\Helpers\DecisionMaking\ROC;
use App\Models\KriteriaOpenRemote;
use App\Models\Mahasiswa;
use App\Traits\BaseKriteriaFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KriteriaOpenRemote>
 */
class KriteriaOpenRemoteFactory extends Factory
{
    use BaseKriteriaFactory;

    protected $model = KriteriaOpenRemote::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rank = $this->faker->numberBetween(1, DecisionMakingEnum::totalCriteria->value);

        return [
            'open_remote' => $this->faker->randomElement(['ya', 'tidak']),
            'mahasiswa_id' => fn() => Mahasiswa::inRandomOrder()->value('id'),
            'rank' => 1,
            'bobot' => ROC::getWeight(1, DecisionMakingEnum::totalCriteria->value)
        ];
    }

    public function configure()
    {
        return $this->withBobotCalculation();
    }
}
