<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'applicant_id',
        'university_id',
        'matricule',
        'chosen_field',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the applicant that owns the scholar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function academic_years()
    {
        return $this->hasMany(AcademicYearRecord::class);
    }

    public function universities()
    {
        return $this->belongsToMany(University::class, 'historique_university_scholars', 'scholar_id', 'university_id')
            ->withPivot('is_current', 'joined_at', 'left_at')
            ->withTimestamps();
    }

    public function application_documents()
    {
        return $this->hasMany(ApplicationDocument::class, 'reviewed_by_scholar');
    }

    public function historique_status_changes()
    {
        return $this->hasMany(HistoriqueStatusChange::class, 'changed_by_scholar_id');
    }
}
