<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_evaluator_id',
        'criteria_id',
        'score_given',
        'comment',
    ];

    public function evaluator()
    {
        return $this->belongsTo(InterviewEvaluator::class, 'interview_evaluator_id');
    }

    public function criteria()
    {
        return $this->belongsTo(EvaluationCriteria::class, 'criteria_id');
    }
}
