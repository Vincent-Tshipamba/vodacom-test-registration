<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\PhaseTest;
use Illuminate\Database\Eloquent\Model;

use function Symfony\Component\Clock\now;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScholarshipEdition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'year',
        'scholar_quota',
        'application_start_date',
        'application_end_date',
        'is_current',
        'is_mixed',
        'status',
    ];

    protected $casts = [
        'application_start_date' => 'datetime',
        'application_end_date' => 'datetime',
    ];

    public static function getCurrentEdition(): ?self
    {
        $active = static::where('is_current', true)
            ->first();
        return $active;
    }

    public static function getActiveEdition(): ?self
    {
        $now = Carbon::now();
        $byWindow = static::where('status', 'SELECTION_PHASE')
            ->where(function ($q) use ($now) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $now);
            })
            ->orderByDesc('year')
            ->orderByDesc('start_date')
            ->first();
        if ($byWindow) {
            return $byWindow;
        }

        $latestSelection = static::where('status', 'SELECTION_PHASE')
            ->orderByDesc('year')
            ->orderByDesc('start_date')
            ->first();
        if ($latestSelection) {
            return $latestSelection;
        }

        return static::orderByDesc('year')
            ->orderByDesc('start_date')
            ->first();
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'edition_id');
    }

    public function evaluationCriteria()
    {
        return $this->hasMany(EvaluationCriteria::class, 'edition_id');
    }

    public function phase_test()
    {
        return $this->hasOne(PhaseTest::class);
    }
}
