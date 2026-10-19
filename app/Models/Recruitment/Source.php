<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $table = 'recruitment_sources';

    protected $fillable = ['name', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
