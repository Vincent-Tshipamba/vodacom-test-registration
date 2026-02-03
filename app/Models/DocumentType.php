<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    /** @use HasFactory<\Database\Factories\DocumentTypeFactory> */
    use HasFactory;
    protected $fillable = ['name', 'description', 'is_for_candidats'];

    public function scholar_documents()
    {
        return $this->hasMany(ScholarDocument::class);
    }

    public function application_documents()
    {
        return $this->hasMany(ApplicationDocument::class);
    }
}
