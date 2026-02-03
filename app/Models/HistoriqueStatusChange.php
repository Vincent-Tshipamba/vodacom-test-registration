<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueStatusChange extends Model
{
    protected $fillable = [
        'applicant_id',
        'agent_id',
        'old_status',
        'new_status',
        'changed_by_scholar_id',
        'changed_by_agent_id',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function changed_by_agent()
    {
        return $this->belongsTo(Agent::class, 'changed_by_agent_id');
    }

    public function changed_by_scholar()
    {
        return $this->belongsTo(Scholar::class, 'changed_by_scholar_id');
    }
}
