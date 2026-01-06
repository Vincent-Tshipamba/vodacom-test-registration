<?php

namespace Database\Seeders;

use App\Models\StaffProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StaffProfile::factory()->count(100)->create();
    }
}
