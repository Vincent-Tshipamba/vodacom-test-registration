<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'started_at',
        'finished_at',
        'total_score',
        'is_passed',
        'cheating_attempts',
        'auto_submitted',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'total_score' => 'decimal:2',
        'is_passed' => 'boolean',
        'auto_submitted' => 'boolean',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function responses()
    {
        return $this->hasMany(CandidateResponse::class);
    }

    public function phase_test()
    {
        return $this->belongsTo(PhaseTest::class);
    }
}
