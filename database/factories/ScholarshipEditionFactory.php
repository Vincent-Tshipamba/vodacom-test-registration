<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use function Symfony\Component\Clock\now;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScholarshipEdition>
 */
class ScholarshipEditionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'year' => $this->faker->year(),
            'status' => $this->faker->randomElement(['OPEN', 'SELECTION_PHASE', 'CLOSED', 'ARCHIVED']),
            'scholar_quota' => $this->faker->numberBetween(0, 100),
            'start_date' => $this->faker->dateTimeThisMonth(),
            'end_date' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
