<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'department_id',
        'job_title',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function application_documents()
    {
        return $this->hasMany(ApplicationDocument::class, 'reviewed_by_agent');
    }

    public function scholarship_documents()
    {
        return $this->hasMany(ScholarshipDocument::class, 'reviewed_by');
    }

    public function interview_evaluators()
    {
        return $this->hasMany(InterviewEvaluator::class, 'evaluator_id');
    }
}
