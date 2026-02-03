<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'educational_city_id',
        'website_url',
        'contact_person_name',
        'contact_person_phone',
        'contact_person_grade',
        'contact_email',
        'contact_phone',
    ];

    public function scholars()
    {
        return $this->belongsToMany(Scholar::class, 'historique_university_scholars', 'university_id', 'scholar_id')
            ->withPivot('is_current', 'joined_at', 'left_at')
            ->withTimestamps();
    }

    public function educational_city()
    {
        return $this->belongsTo(EducationalCity::class, 'educational_city_id');
    }
}
