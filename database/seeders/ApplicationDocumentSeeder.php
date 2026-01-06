<?php

namespace Database\Seeders;

use App\Models\ApplicationDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ApplicationDocument::factory()->count(200)->create();
    }
}
