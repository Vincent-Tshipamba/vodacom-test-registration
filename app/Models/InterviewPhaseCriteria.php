<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewPhaseCriteria extends Model
{
    protected $fillable = [
        'interview_phase_id',
        'criteria_id',
        'ponderation',
    ];

    public function interviewPhase()
    {
        return $this->belongsTo(InterviewPhase::class, 'interview_phase_id');
    }

    public function evaluationCriteria()
    {
        return $this->belongsTo(EvaluationCriteria::class, 'criteria_id');
    }
}
