<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhaseTest extends Model
{
    protected $fillable = [
        'scholarship_edition_id',
        'description',
        'duration',
        'start_time',
        'end_time',
        'total_questions',
        'passing_score',
        'status',
    ];

    public function scholarship_edition()
    {
        return $this->belongsTo(ScholarshipEdition::class, 'scholarship_edition_id');
    }

    public function test_sessions()
    {
        return $this->hasMany(TestSession::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_phase_tests', 'phase_test_id', 'question_id')
                    ->withPivot('ponderation')
                    ->withTimestamps();
    }

    public function place_tests()
    {
        return $this->belongsToMany(PlaceTest::class, 'phase_place_tests', 'phase_test_id', 'place_test_id');
    }
}
