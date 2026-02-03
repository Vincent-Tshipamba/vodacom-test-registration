<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'document_type_id',
        'file_url',
        'file_type',
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

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function reviewed_by_agent()
    {
        return $this->belongsTo(Agent::class, 'reviewed_by_agent');
    }

    public function reviewed_by_scholar()
    {
        return $this->belongsTo(Scholar::class, 'reviewed_by_scholar');
    }
}
