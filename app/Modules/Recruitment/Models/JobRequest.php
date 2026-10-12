<?php

namespace App\Modules\Recruitment\Models;

use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobRequest extends Model
{
    use SoftDeletes;

    protected $table = 'recruitment_job_requests';

    protected $fillable = [
        'code', 'department_id', 'position_id', 'requested_by', 'quantity',
        'reason', 'target_date', 'status', 'approved_by', 'approved_at', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'target_date' => 'date:Y-m-d',
            'approved_at' => 'datetime',
            'status' => \App\Modules\Recruitment\Enums\JobRequestStatus::class,
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function jobPostings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(JobPosting::class);
    }
}
