<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    use HasFactory;

    protected $table = 'evaluation_criteria';

    protected $fillable = [
        'criteria_name',
        'description',
    ];


    public function evaluationScores()
    {
        return $this->hasMany(EvaluationScore::class, 'criteria_id');
    }

    public function interviewPhases()
    {
        return $this->belongsToMany(InterviewPhase::class, 'interview_phase_criterias', 'criteria_id', 'interview_phase_id')
            ->withPivot('ponderation')
            ->withTimestamps();
    }
}
