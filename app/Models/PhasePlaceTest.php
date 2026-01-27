<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhasePlaceTest extends Model
{
    protected $fillable = ['phase_test_id', 'place_test_id'];

    public function phase_test()
    {
        return $this->belongsTo(PhaseTest::class, 'phase_test_id');
    }

    public function place_test()
    {
        return $this->belongsTo(PlaceTest::class, 'place_test_id');
    }
}
