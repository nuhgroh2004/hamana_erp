<?php

namespace App\Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Interview extends Model
{
    protected $table = 'recruitment_interviews';

    protected $fillable = [
        'application_id', 'type', 'scheduled_at', 'duration_minutes',
        'location', 'status', 'recommendation',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'duration_minutes' => 'integer',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(InterviewParticipant::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(InterviewScore::class);
    }
}
