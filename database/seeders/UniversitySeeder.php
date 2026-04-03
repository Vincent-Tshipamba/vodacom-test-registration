<?php

namespace Database\Seeders;

use App\Models\EducationalCity;
use App\Models\University;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $universities = [
            'Université de Kinshasa',
            'Université de Lubumbashi',
            'Université de Goma',
            'Université de Kisangani',
            'Université de Bukavu',
            'Université de Mbandaka',
            'Université de Kananga',
            'Université de Matadi',
            'Université de Tshikapa',
            'Université de Kindu',
            'Université de Kalemie',
            'Université de Boma',
            'Université de Uvira',
            'Université de Mwene-Ditu',
            'Université de Gemena',
            'Université de Lisala',
            'Université de Beni',
            'Université de Butembo',
            'Université de Isiro',
            'Université de Dungu',
            'Institut Supérieur Pédagogique de Bukavu',
            'Institut Supérieur d\'Architecture et d\'Urbanisme de Kinshasa',
            'Institut Supérieur des Techniques Médicales de Lubumbashi',
            'Institut Supérieur de Commerce de Goma',
            'Institut Supérieur de Technologie de Kisangani',
            'Institut Supérieur des Sciences Agronomiques de Mbandaka',
            'Institut Supérieur Pédagogique de Kinshasa',
            'Institut Supérieur des Arts et Métiers de Kinshasa',
            'Institut Supérieur d\'Informatique Programmation et Analyse de Kinshasa',
            'Haute École de Commerce de Kinshasa',
            'Université Protestante au Congo',
            'Université Catholique de Bukavu',
            'Université Pedagogique Nationale',
            'Université Libre des Pays des Grands Lacs',
            'Leadership Academia University',
        ];

        foreach ($universities as $universityName) {
            University::create([
                'name' => $universityName,
                'educational_city_id' => EducationalCity::inRandomOrder()->first()->id,
                'contact_email' => strtolower(str_replace(' ', '_', $universityName)) .'@example.com',
                'contact_phone' => '+243' . rand(800000000, 899999999),
                'contact_person_name' => 'Responsable ' . $universityName,
                'contact_person_phone' => '+243' . rand(800000000, 899999999),
                'website_url' => 'https://www.' . strtolower(str_replace(' ', '', $universityName)) . '.com',
            ]);
        }
    }
}
