<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_session_id',
        'question_phase_test_id',
        'selected_option_id',
        'text_answer',
    ];

    public function test_session()
    {
        return $this->belongsTo(TestSession::class);
    }

    public function question_phase_test()
    {
        return $this->belongsTo(QuestionPhaseTest::class);
    }

    public function selected_option()
    {
        return $this->belongsTo(AnswerOption::class, 'selected_option_id');
    }
}
