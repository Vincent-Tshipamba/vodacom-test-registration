<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'question_text',
        'question_type',
        'ponderation',
    ];

    public function options()
    {
        return $this->hasMany(AnswerOption::class);
    }
}
