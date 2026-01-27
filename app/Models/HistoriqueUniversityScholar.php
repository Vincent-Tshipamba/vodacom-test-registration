<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueUniversityScholar extends Model
{
    protected $fillable = [
        'university_id',
        'scholar_id',
        'is_current',
        'joined_at',
        'left_at'
    ];

    public function scholar()
    {
        return $this->belongsTo(Scholar::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
