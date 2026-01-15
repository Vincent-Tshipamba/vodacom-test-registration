<?php

namespace Database\Seeders;

use App\Models\Applicant;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\ApplicationDocument;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $applicants = Applicant::factory()->count(100)->create();

        $testFiles = [
            'PHOTO' => 'applicants/1/photos/vincent_tshipamba_photo_20260106_122233.png',
            'ID' => 'applicants/1/ids/vincent_tshipamba_id_20260106_122234.pdf',
            'DIPLOMA' => 'applicants/1/diplomas/vincent_tshipamba_diploma_20260106_122234.pdf',
            'RECO_LETTER' => 'applicants/1/reco_letters/vincent_tshipamba_reco_letter_20260106_122234.pdf'
        ];

        $applicants->each(function ($applicant) use ($testFiles) {
            $storagePath = storage_path('app/public/');
            foreach ($testFiles as $type => $filePath) {
                $newPath = str_replace(
                    'applicants/1/',
                    "applicants/{$applicant->id}/",
                    $filePath
                );

                $sourcePath = $storagePath . $filePath;
                $destinationPath = $storagePath . $newPath;

                $directory = dirname($destinationPath);
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true);
                }
                // Copier le fichier
                if (File::exists($sourcePath)) {
                    File::copy($sourcePath, $destinationPath);
                }
                ApplicationDocument::create([
                    'applicant_id' => $applicant->id,
                    'document_type' => $type,
                    'file_type' => pathinfo($newPath, PATHINFO_EXTENSION),
                    'file_url' => $newPath,
                    'file_name' => basename($newPath),
                    'is_valid' => false,
                    'uploaded_at' => now(),
                ]);
            }
        });
    }
}
