<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_record_id',
        'amount',
        'currency',
        'transaction_reference',
        'payment_status',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    public function acadmic_year_record()
    {
        return $this->belongsTo(AcademicYearRecord::class, 'academic_year_record_id');
    }
}
