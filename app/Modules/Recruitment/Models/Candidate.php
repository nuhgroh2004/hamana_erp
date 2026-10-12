<?php

namespace App\Modules\Recruitment\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use SoftDeletes;

    protected $table = 'recruitment_candidates';

    protected $fillable = [
        'name', 'email', 'phone', 'national_id', 'birth_date', 'city',
        'education', 'experience_years', 'source_id', 'user_id',
        'is_talent_pool', 'talent_tags', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date:Y-m-d',
            'is_talent_pool' => 'boolean',
            'talent_tags' => 'array',
        ];
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(CandidateDocument::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
