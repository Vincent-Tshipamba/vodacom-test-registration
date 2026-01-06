<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StaffProfile>
 */
class StaffProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement(User::pluck('id')),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'department_id' => $this->faker->randomElement(Department::pluck('id')),
            'job_title' => $this->faker->jobTitle,
        ];
    }
}
