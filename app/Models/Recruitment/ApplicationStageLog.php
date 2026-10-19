<?php

namespace App\Models\Recruitment;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationStageLog extends Model
{
    const UPDATED_AT = null;

    protected $table = 'recruitment_application_stage_logs';

    protected $fillable = [
        'application_id', 'from_stage_id', 'to_stage_id', 'changed_by', 'reason', 'created_at',
    ];

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function fromStage(): BelongsTo
    {
        return $this->belongsTo(Stage::class, 'from_stage_id');
    }

    public function toStage(): BelongsTo
    {
        return $this->belongsTo(Stage::class, 'to_stage_id');
    }

    public function changer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
