<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryQuestion;

class CategoryQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Francais', 'description' => 'Questions de langue francaise'],
            ['name' => 'Anglais', 'description' => 'Questions de langue anglaise'],
            ['name' => 'Culture Generale', 'description' => 'Questions de culture generale'],
            ['name' => 'Maths', 'description' => 'Questions de mathematiques'],
            ['name' => 'Psychotechnique', 'description' => 'Questions psychotechniques'],
        ];

        foreach ($categories as $category) {
            CategoryQuestion::updateOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
