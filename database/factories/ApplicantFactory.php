<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\ScholarshipEdition;
use Illuminate\Database\Eloquent\Factories\Factory;

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

        $studied_options = [
            'Aides-Soignantes',
            'Arts et métiers',
            'Commerciale',
            'Coupe & Couture',
            'Electricité',
            'Electronique',
            'Littéraire',
            'Mécanique',
            'Pédagogie',
            'Scientifique',
            'Secrétariat',
        ];

        $university_fields = [
            'Génie Civil',
            'Génie Mécanique',
            'Génie Électrique',
            'Génie Logiciel',
            'Génie Informatique',
            'Génie Chimique',
            'Génie des Télécommunications',
            'Mathématiques Appliquées',
            'Physique',
            'Chimie',
            'Biologie',
            'Géologie',
            'Sciences Environnementales',
            'Sciences Économiques',
            'Sciences de Gestion',
            'Gestion des Entreprises',
            'Gestion des Ressources Humaines',
            'Marketing',
            'Comptabilité et Finance',
            'Banque et Finance',
            'Assurances',
            'Droit Privé et Judiciaire',
            'Droit Public',
            'Droit International',
            'Droit Économique',
            'Médecine Générale',
            'Dentisterie',
            'Pharmacie',
            'Sciences Infirmières',
            'Santé Publique',
            'Philosophie',
            'Histoire',
            'Sociologie',
            'Psychologie',
            'Sciences Politiques',
            'Relations Internationales',
            'Agronomie Générale',
            'Sciences Vétérinaires',
            'Sciences et Techniques de Développement',
        ];

        return [
            'user_id' => $this->faker->randomElement(User::pluck('id')),
            'edition_id' => $this->faker->randomElement(ScholarshipEdition::pluck('id')),
            'registration_code' => Str::random(6),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'date_of_birth' => $this->faker->dateTimeBetween('-21 years', '-15 years'),
            'phone_number' => $this->faker->phoneNumber,
            'vulnerability_type' => $this->faker->randomElement($vulnerability_types),
            'diploma_city' => $this->faker->city,
            'current_city' => $this->faker->city,
            'full_address' => $this->faker->address,
            'school_name' => $this->faker->word,
            'national_exam_code' => $this->faker->numerify('##############'),
            'percentage' => $this->faker->numberBetween(70, 100),
            'option_studied' => $this->faker->randomElement($studied_options),
            'intended_field' => $this->faker->randomElement($university_fields),
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
