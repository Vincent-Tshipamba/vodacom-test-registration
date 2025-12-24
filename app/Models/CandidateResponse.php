<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_session_id',
        'question_id',
        'selected_option_id',
        'text_answer',
    ];

    public function session()
    {
        return $this->belongsTo(TestSession::class, 'test_session_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedOption()
    {
        return $this->belongsTo(AnswerOption::class, 'selected_option_id');
    }
}
