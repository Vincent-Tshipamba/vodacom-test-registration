<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'edition_id',
        'criteria_name',
        'max_points',
    ];

    public function edition()
    {
        return $this->belongsTo(ScholarshipEdition::class, 'edition_id');
    }

    public function evaluationScores()
    {
        return $this->hasMany(EvaluationScore::class, 'criteria_id');
    }
}
