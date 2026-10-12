<?php

namespace App\Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RejectionReason extends Model
{
    protected $table = 'recruitment_rejection_reasons';

    protected $fillable = ['name', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'rejected_reason_id');
    }
}
