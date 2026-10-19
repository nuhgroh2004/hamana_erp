<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class RejectionReason extends Model
{
    protected $table = 'recruitment_rejection_reasons';

    protected $fillable = ['name', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
