<?php

namespace App\Models;

use App\Models\CategoryQuestion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_question_id',
        'question_text',
        'question_type',
    ];

    public function answer_options()
    {
        return $this->belongsToMany(AnswerOption::class, 'question_answer_options', 'question_id', 'answer_option_id')
            ->withPivot('is_correct')
            ->withTimestamps();
    }

    public function category_question()
    {
        return $this->belongsTo(CategoryQuestion::class);
    }

    public function phase_tests()
    {
        return $this->belongsToMany(PhaseTest::class, 'question_phase_tests', 'question_id', 'phase_test_id')
            ->withPivot('ponderation')
            ->withTimestamps();
    }
}
