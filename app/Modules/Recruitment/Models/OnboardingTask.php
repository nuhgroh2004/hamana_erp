<?php

namespace App\Modules\Recruitment\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnboardingTask extends Model
{
    protected $table = 'recruitment_onboarding_tasks';

    protected $fillable = ['onboarding_id', 'title', 'is_done', 'done_by', 'done_at'];

    protected function casts(): array
    {
        return ['is_done' => 'boolean', 'done_at' => 'datetime'];
    }

    public function onboarding(): BelongsTo
    {
        return $this->belongsTo(Onboarding::class, 'onboarding_id');
    }

    public function doer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'done_by');
    }
}
