<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    use HasFactory;

    protected $fillable = [
        // Informations personnelles
        'firstname',
        'lastname',
        'phone',
        'photo',
        'gender',
        'birthdate',
        'identification_type',

        // Adresse
        'current_city',
        'diploma_city',
        'full_address',

        // Informations scolaires
        'school_name',
        'study_option',
        'diploma_score',
        'student_code',

        // Documents
        'id_document_path',
        'diploma_path',
        'recommendation_path',

        // Ambitions personnelles
        'university_field',
        'passion',
        'passion_locale',
        'career_goals',
        'career_goals_locale',
        'additional_infos',
        'additional_infos_locale',

        'coupon',
        'status'
    ];
}
