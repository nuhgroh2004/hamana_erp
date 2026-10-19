<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class OnboardingTemplate extends Model
{
    protected $table = 'recruitment_onboarding_templates';

    protected $fillable = ['title', 'order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
