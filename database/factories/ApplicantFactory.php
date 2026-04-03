<?php

namespace Database\Factories;

use App\Helpers\FormOptionsHelper;
use App\Models\EducationalCity;
use App\Models\ScholarshipEdition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Applicant>
 */
class ApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $application_status = [
            'PENDING',
            'REJECTED',
            'SHORTLISTED',
            'TEST_PASSED',
            'INTERVIEW_PASSED',
            'ADMITTED'
        ];

        $vulnerability_types = [
            'disabled',
            'albinos',
            'pygmee',
            'refugee',
            'orphan',
            'none',
        ];

        $studyOptions = FormOptionsHelper::getStudyOptions();

        $universityFields = FormOptionsHelper::getUniversityFields();

        return [
            'edition_id' => $this->faker->randomElement(ScholarshipEdition::pluck('id')),
            'registration_code' => Str::random(6),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'date_of_birth' => $this->faker->dateTimeBetween('-21 years', '-15 years'),
            'phone_number' => $this->faker->phoneNumber,
            'vulnerability_type' => $this->faker->randomElement($vulnerability_types),
            'educational_city_id' => fake()->randomElement(EducationalCity::pluck('id'))    ,
            'current_city_id' => fake()->randomElement(EducationalCity::pluck('id')),
            'full_address' => $this->faker->address,
            'school_name' => $this->faker->word,
            'national_exam_code' => $this->faker->numerify('##############'),
            'percentage' => $this->faker->numberBetween(70, 100),
            'option_studied' => $this->faker->randomElement($studyOptions),
            'intended_field' => $this->faker->randomElement($universityFields),
            'intended_field_motivation' => $this->faker->sentence,
            'intended_field_motivation_locale' => $this->faker->randomElement(['fr', 'en', 'ln', 'sw']),
            'career_goals' => $this->faker->sentence,
            'career_goals_locale' => $this->faker->randomElement(['fr', 'en', 'ln', 'sw']),
            'additional_infos' => $this->faker->text,
            'additional_infos_locale' => $this->faker->randomElement(['fr', 'en', 'ln', 'sw']),
            'application_status' => $this->faker->randomElement($application_status),
        ];
    }
}
