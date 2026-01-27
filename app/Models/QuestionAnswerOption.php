<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswerOption extends Model
{
    protected $fillable = [
        'question_id',
        'answer_option_id',
        'is_correct'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer_option()
    {
        return $this->belongsTo(AnswerOption::class);
    }
}
