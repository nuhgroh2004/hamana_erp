<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormResponse extends Model
{
    protected $table = 'recruitment_form_responses';

    protected $fillable = [
        'form_id', 'submitted_at', 'values', 'files',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'values' => 'array',
            'files' => 'array',
        ];
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
