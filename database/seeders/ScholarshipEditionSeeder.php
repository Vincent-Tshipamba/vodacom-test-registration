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
        // ScholarshipEdition::factory()->count(10)->create();
        $editions = [
            [
                'name' => 'Edition 2019',
                'year' => 2019,
                'scholar_quota' => 25,
                'application_start_date' => '2019-07-01',
                'application_end_date' => '2019-08-31',
                'is_current' => false,
                'is_mixed' => true,
                'status' => 'ARCHIVED',
            ],
            [
                'name' => 'Edition 2020',
                'year' => 2020,
                'scholar_quota' => 25,
                'application_start_date' => '2020-07-01',
                'application_end_date' => '2020-08-31',
                'is_current' => false,
                'is_mixed' => true,
                'status' => 'ARCHIVED',
            ],
            [
                'name' => 'Edition 2021',
                'year' => 2021,
                'scholar_quota' => 25,
                'application_start_date' => '2021-07-01',
                'application_end_date' => '2021-08-31',
                'is_current' => false,
                'is_mixed' => true,
                'status' => 'OPEN',
            ],
            [
                'name' => 'Edition 2022',
                'year' => 2022,
                'scholar_quota' => 25,
                'application_start_date' => '2022-07-01',
                'application_end_date' => '2022-08-31',
                'is_current' => false,
                'is_mixed' => true,
                'status' => 'OPEN',
            ],
            [
                'name' => 'Edition 2023',
                'year' => 2023,
                'scholar_quota' => 100,
                'application_start_date' => '2023-07-01',
                'application_end_date' => '2023-08-31',
                'is_current' => false,
                'is_mixed' => true,
                'status' => 'OPEN',
            ],
            [
                'name' => 'Edition 2024',
                'year' => 2024,
                'scholar_quota' => 50,
                'application_start_date' => '2024-07-01',
                'application_end_date' => '2024-08-31',
                'is_current' => false,
                'is_mixed' => true,
                'status' => 'OPEN',
            ],//SELECTION_PHASE, INTERVIEW_PHASE, TEST_PHASE, OPEN, CLOSED, ARCHIVED
            [
                'name' => 'Edition 2025',
                'year' => 2025,
                'scholar_quota' => 50,
                'application_start_date' => '2025-07-01',
                'application_end_date' => '2025-08-31',
                'is_current' => false,
                'is_mixed' => false,
                'status' => 'OPEN',
            ],
            [
                'name' => 'Edition 2026',
                'year' => 2026,
                'scholar_quota' => 50,
                'application_start_date' => '2026-07-01',
                'application_end_date' => '2026-08-31',
                'is_current' => true,
                'is_mixed' => false,
                'status' => 'SELECTION_PHASE',
            ]
        ];

        foreach ($editions as $edition) {
            ScholarshipEdition::create($edition);
        }
    }
}
