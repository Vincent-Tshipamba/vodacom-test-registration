<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'document_type',
        'file_url',
        'file_name',
        'is_valid',
        'reviewed_by_agent',
        'reviewed_by_scholar',
        'reviewed_at',
        'uploaded_at',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
        'reviewed_at' => 'datetime',
        'uploaded_at' => 'datetime',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function reviewed_by_agent()
    {
        return $this->belongsTo(StaffProfile::class, 'reviewed_by_agent');
    }

    public function reviewed_by_scholar()
    {
        return $this->belongsTo(Scholar::class, 'reviewed_by_scholar');
    }
}
