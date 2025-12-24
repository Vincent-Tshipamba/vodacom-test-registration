<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewEvaluator extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_session_id',
        'evaluator_id',
    ];

    public function interviewSession()
    {
        return $this->belongsTo(InterviewSession::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(StaffProfile::class, 'evaluator_id');
    }

    public function scores()
    {
        return $this->hasMany(EvaluationScore::class);
    }
}
