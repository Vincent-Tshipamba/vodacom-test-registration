<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'option_text',
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_answer_options', 'answer_option_id', 'question_id')
            ->withPivot('is_correct')
            ->withTimestamps();
    }

    public function candidate_responses()
    {
        return $this->hasMany(CandidateResponse::class, 'selected_option_id');
    }
}
