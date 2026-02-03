<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $document_types = [
            [
                'name' => 'DIPLOMA',
                'description' => 'Diploma or certificate of the highest level of education attained by the applicant.',
                'is_for_candidats' => true,
            ],
            [
                'name' => 'ID',
                'description' => 'National identification document of the applicant.',
                'is_for_candidats' => true,
            ],
            [
                'name' => 'PHOTO',
                'description' => 'Recent passport-sized photograph of the applicant.',
                'is_for_candidats' => true,
            ],
            [
                'name' => 'RECO_LETTER',
                'description' => 'Letter of recommendation',
                'is_for_candidats' => true,
            ],
            [
                'name' => 'REGISTRATION_PROOF',
                'description' => 'Proof of registration for the current academic year.',
                'is_for_candidats' => false,
            ],
            [
                'name' => 'FEES_RECEIPT',
                'description' => 'Receipt of payment for tuition or other academic fees.',
                'is_for_candidats' => false,
            ],
            [
                'name' => 'RESULTS_PROOF',
                'description' => 'Official document showing the results of the applicant\'s most recent examinations.',
                'is_for_candidats' => false,
            ]
        ];

        foreach ($document_types as $type) {
            DocumentType::create($type);
        }
    }
}
