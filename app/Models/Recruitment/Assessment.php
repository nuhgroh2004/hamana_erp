<?php

namespace App\Models\Recruitment;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assessment extends Model
{
    protected $table = 'recruitment_assessments';

    protected $fillable = [
        'application_id', 'type', 'score', 'passed', 'assessor_id',
        'notes', 'attachment_path', 'assessed_at',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'float',
            'passed' => 'boolean',
            'assessed_at' => 'datetime',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function assessor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assessor_id');
    }
}
