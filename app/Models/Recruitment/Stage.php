<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $table = 'recruitment_stages';

    protected $fillable = ['name', 'order', 'is_active', 'is_final'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_final' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
