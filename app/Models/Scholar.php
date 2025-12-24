<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholar extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'university_id',
        'matricule',
        'chosen_field',
        'status',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function academicYears()
    {
        return $this->hasMany(AcademicYearRecord::class);
    }
}
