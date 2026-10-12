<?php

namespace App\Modules\Recruitment\Models;

use App\Models\Karyawan;
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

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'employee_id', 'nik');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(OnboardingTask::class, 'onboarding_id');
    }
}
