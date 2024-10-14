<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'code_exetat',
        'pourcentage',
        'photo',
        'identity',
        'certificate',
        'coupon',
        'status'
    ];
}
