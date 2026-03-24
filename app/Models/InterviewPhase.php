<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewPhase extends Model
{
    protected $fillable = [
        'description',
        'scholarship_edition_id',
        'duration',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function scholarshipEdition()
    {
        return $this->belongsTo(ScholarshipEdition::class);
    }

    public function evaluationCriteria()
    {
        return $this->belongsToMany(EvaluationCriteria::class, 'interview_phase_criterias', 'interview_phase_id', 'criteria_id')
            ->withPivot('ponderation')
            ->withTimestamps();
    }

    public function criteria()
    {
        return $this->belongsToMany(EvaluationCriteria::class, 'interview_phase_criterias', 'interview_phase_id', 'criteria_id')
            ->withPivot('ponderation')
            ->withTimestamps();
    }

    public function interviewSessions()
    {
        return $this->hasMany(InterviewSession::class);
    }
}
