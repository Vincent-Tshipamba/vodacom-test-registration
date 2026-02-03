<?php

namespace App\Models;

use App\Models\PlaceTest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EducationalCity extends Model
{
    /** @use HasFactory<\Database\Factories\EducationalCityFactory> */
    use HasFactory;

    protected $fillable = ['name'];

    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'educational_city_id');
    }

    public function current_residents()
    {
        return $this->hasMany(Applicant::class, 'current_city_id');
    }

    public function place_tests()
    {
        return $this->hasMany(PlaceTest::class);
    }

    public function universities()
    {
        return $this->hasMany(University::class);
    }
}
