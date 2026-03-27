<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'started_at',
        'scheduled_at',
        'final_average_score',
        'decision_comment',
        'interview_phase_id',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'final_average_score' => 'decimal:2',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function evaluators()
    {
        return $this->belongsToMany(Agent::class, 'interview_evaluators', 'interview_session_id', 'evaluator_id')
            ->withTimestamps();
    }

    public function interviewPhase()
    {
        return $this->belongsTo(InterviewPhase::class);
    }
}
