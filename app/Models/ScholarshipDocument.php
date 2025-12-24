<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_record_id',
        'document_type',
        'file_url',
        'file_name',
        'verification_status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
        'uploaded_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'uploaded_at' => 'datetime',
    ];

    public function record()
    {
        return $this->belongsTo(AcademicYearRecord::class, 'academic_year_record_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(StaffProfile::class, 'reviewed_by');
    }
}
