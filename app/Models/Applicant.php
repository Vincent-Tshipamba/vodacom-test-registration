<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'edition_id',
        'registration_code',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone_number',
        'vulnerability_type',
        'diploma_city',
        'current_city',
        'full_address',
        'school_name',
        'national_exam_code',
        'percentage',
        'option_studied',
        'intended_field',
        'intended_field_motivation',
        'intended_field_motivation_locale',
        'career_goals',
        'career_goals_locale',
        'additional_infos',
        'additional_infos_locale',
        'application_status',
    ];

    protected $appends = ['full_name', 'documents'];

    protected $casts = [
        'date_of_birth' => 'date',
        'percentage' => 'decimal:2',
    ];

    public function getAge(): int
    {
        $today = now();
        $age = $today->year - $this->date_of_birth->year;

        if ($today->month < $this->date_of_birth->month || ($today->month == $this->date_of_birth->month && $today->day < $this->date_of_birth->day)) {
            $age--;
        }

        return $age;
    }


    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getDocumentsAttribute()
    {
        return (object) $this->application_documents
            ->mapWithKeys(fn($doc) => [
                strtolower($doc->document_type) => [
                    'id' => $doc->id,
                    'type' => $doc->document_type,
                    'url' => Storage::url($doc->file_url),
                    'ext' => $doc->file_type,
                    'is_pdf' => $doc->file_type === 'pdf',
                ]
            ])->toArray();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function edition()
    {
        return $this->belongsTo(ScholarshipEdition::class, 'edition_id');
    }

    public function application_documents()
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function testSessions()
    {
        return $this->hasMany(TestSession::class);
    }

    public function interviewSessions()
    {
        return $this->hasMany(InterviewSession::class);
    }

    public function scholar()
    {
        return $this->hasOne(Scholar::class);
    }
}
