<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;

    protected $table = 'recruitment_applications';

    protected $fillable = [
        'candidate_id', 'job_posting_id', 'current_stage_id', 'status',
        'rejected_reason_id', 'active_key', 'applied_at', 'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'applied_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    public function jobPosting(): BelongsTo
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function currentStage(): BelongsTo
    {
        return $this->belongsTo(Stage::class, 'current_stage_id');
    }

    public function rejectedReason(): BelongsTo
    {
        return $this->belongsTo(RejectionReason::class);
    }

    public function stageLogs(): HasMany
    {
        return $this->hasMany(ApplicationStageLog::class);
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }

    public function interviews(): HasMany
    {
        return $this->hasMany(Interview::class);
    }

    public function offer(): HasOne
    {
        return $this->hasOne(Offer::class);
    }

    public function onboarding(): HasOne
    {
        return $this->hasOne(Onboarding::class);
    }
}
