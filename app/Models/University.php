<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'website_url',
        'contact_person_name',
        'contact_person_phone',
        'contact_person_grade',
        'contact_email',
        'contact_phone',
    ];

    public function scholars()
    {
        return $this->hasMany(Scholar::class);
    }
}
