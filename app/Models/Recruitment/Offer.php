<?php

namespace App\Models\Recruitment;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    protected $table = 'recruitment_offers';

    protected $fillable = [
        'application_id', 'base_salary', 'allowance', 'start_date',
        'valid_until', 'status', 'approved_by', 'responded_at',
    ];

    protected function casts(): array
    {
        return [
            'base_salary' => 'float',
            'allowance' => 'float',
            'start_date' => 'date:Y-m-d',
            'valid_until' => 'date:Y-m-d',
            'responded_at' => 'datetime',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
