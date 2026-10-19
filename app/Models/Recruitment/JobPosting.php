<?php

namespace App\Models\Recruitment;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPosting extends Model
{
    use SoftDeletes;

    protected $table = 'recruitment_job_postings';

    protected $fillable = [
        'job_request_id', 'title', 'department_id', 'location', 'quota',
        'description', 'requirements', 'requires_certificate', 'deadline',
        'priority', 'status', 'published_at', 'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date:Y-m-d',
            'published_at' => 'datetime',
            'closed_at' => 'datetime',
            'requires_certificate' => 'boolean',
        ];
    }

    public function jobRequest(): BelongsTo
    {
        return $this->belongsTo(JobRequest::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function applicantCount(): int
    {
        return $this->applications()->count();
    }

    public function hiredCount(): int
    {
        return $this->applications()->where('status', 'hired')->count();
    }
}
