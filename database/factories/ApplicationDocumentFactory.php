<?php

namespace Database\Factories;

use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApplicationDocument>
 */
class ApplicationDocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'applicant_id' => $this->faker->randomElement(Applicant::pluck('id')),
            'document_type' => $this->faker->randomElement(['PHOTO', 'ID', 'DIPLOMA', 'RECO_LETTER']),
            'file_url' => $this->faker->imageUrl(),
            'file_name' => $this->faker->word() . '.jpg',
            'is_valid' => $this->faker->boolean(0),
            // 'reviewed_by_agent',
            // 'reviewed_by_scholar',
            // 'reviewed_at',
            'uploaded_at' => now(),
        ];
    }
}
