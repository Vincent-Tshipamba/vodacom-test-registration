<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionPhaseTest extends Model
{
    protected $fillable = [
        'question_id',
        'phase_test_id',
        'ponderation'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function phase_test()
    {
        return $this->belongsTo(PhaseTest::class);
    }

    public function candidate_responses()
    {
        return $this->hasMany(CandidateResponse::class);
    }
}
