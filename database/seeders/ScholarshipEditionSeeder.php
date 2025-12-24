<?php

namespace Database\Seeders;

use App\Models\ScholarshipEdition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScholarshipEditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ScholarshipEdition::factory()->count(10)->create();
    }
}
