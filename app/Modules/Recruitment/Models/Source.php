<?php

namespace App\Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model
{
    protected $table = 'recruitment_sources';

    protected $fillable = ['name', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }
}
