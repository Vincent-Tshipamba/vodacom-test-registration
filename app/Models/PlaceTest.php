<?php

namespace App\Models;

use App\Models\PhasePlaceTest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlaceTest extends Model
{
    /** @use HasFactory<\Database\Factories\PlaceTestFactory> */
    use HasFactory;

    protected $fillable = ['name', 'address', 'description', 'educational_city_id'];

    public function educational_city()
    {
        return $this->belongsTo(EducationalCity::class);
    }

    public function phase_tests()
    {
        return $this->belongsToMany(PhaseTest::class, 'phase_place_tests', 'place_test_id', 'phase_test_id');
    }
}
