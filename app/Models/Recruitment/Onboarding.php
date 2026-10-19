<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Onboarding extends Model
{
    protected $table = 'recruitment_onboardings';

    protected $fillable = ['application_id', 'employee_id', 'start_date', 'status'];

    protected function casts(): array
    {
        return ['start_date' => 'date:Y-m-d'];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(OnboardingTask::class, 'onboarding_id')->orderBy('id');
    }

    public static function ensureFor(Application $application): self
    {
        if ($application->onboarding) {
            return $application->onboarding;
        }

        $start = $application->offer?->start_date ?? now()->toDateString();
        $onboarding = self::create([
            'application_id' => $application->id,
            'start_date' => $start,
            'status' => 'ongoing',
        ]);

        foreach (OnboardingTemplate::where('is_active', true)->orderBy('order')->get() as $t) {
            $onboarding->tasks()->create(['title' => $t->title]);
        }

        return $onboarding;
    }
}
