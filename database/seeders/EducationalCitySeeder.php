<?php

namespace Database\Seeders;

use App\Models\EducationalCity;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EducationalCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'Kinshasa',
            'Lubumbashi',
            'Mbuji-Mayi',
            'Kisangani',
            'Kananga',
            'Likasi',
            'Goma',
            'Bukavu',
            'Kolwezi',
            'Matadi',
            'Boma',
            'Uvira',
            'Bunia',
            'Kikwit',
            'Kalemie',
            'Isiro',
            'Kindu',
            'Butembo',
            'Tshikapa',
            'Mwene-Ditu',
            'Tshikapa',
            'Gemena',
            'Lisala',
            'Beni',
        ];

        foreach ($cities as $city) {
            EducationalCity::create(['name' => $city]);
        }
    }
}
