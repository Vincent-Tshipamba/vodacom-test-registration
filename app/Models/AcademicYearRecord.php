<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYearRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'scholar_id',
        'academic_year_label',
        'academic_level',
        'registration_proof_submitted',
        'scholarship_paid',
        'payment_proof_submitted',
        'final_result',
    ];

    protected $casts = [
        'registration_proof_submitted' => 'boolean',
        'scholarship_paid' => 'boolean',
        'payment_proof_submitted' => 'boolean',
    ];

    public function scholar()
    {
        return $this->belongsTo(Scholar::class);
    }

    public function documents()
    {
        return $this->hasMany(ScholarshipDocument::class, 'academic_year_record_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'academic_year_record_id');
    }
}
