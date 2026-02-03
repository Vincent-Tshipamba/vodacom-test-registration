<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScholarDocument extends Model
{
    protected $fillable = [
        'academic_year_record_id',
        'document_type_id',
        'file_url',
        'file_name',
        'verification_status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
        'uploaded_at',
    ];

    public function academic_year_record()
    {
        return $this->belongsTo(AcademicYearRecord::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(Agent::class, 'reviewed_by');
    }

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class);
    }
}
