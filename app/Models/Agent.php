<?php

namespace App\Models;

use App\Models\HistoriqueStatusChange;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agent extends Model
{
    /** @use HasFactory<\Database\Factories\AgentFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'department_id', 'job_title'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function interview_sessions()
    {
        return $this->belongsToMany(InterviewSession::class, 'interview_evaluators', 'evaluator_id', 'interview_session_id')
                    ->withTimestamps();
    }

    public function application_documents()
    {
        return $this->hasMany(ApplicationDocument::class, 'reviewed_by_agent');
    }

    public function historique_status_changes()
    {
        return $this->hasMany(HistoriqueStatusChange::class, 'changed_by_agent_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'processed_by');
    }

    public function scholar_documents()
    {
        return $this->hasMany(ScholarDocument::class, 'reviewed_by');
    }
}
