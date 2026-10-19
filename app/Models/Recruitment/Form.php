<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use SoftDeletes;

    protected $table = 'recruitment_forms';

    protected $fillable = [
        'title', 'description', 'slug', 'is_active',
        'success_msg', 'response_limit', 'close_at',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Form $form) {
            $form->fields()->forceDelete();
            $form->responses()->forceDelete();
        });
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'close_at' => 'date:Y-m-d',
        ];
    }

    public function fields(): HasMany
    {
        return $this->hasMany(FormField::class, 'form_id')->orderBy('ord')->orderBy('id');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(FormResponse::class, 'form_id');
    }

    public function publicUrl(): string
    {
        return route('rekrutmen.form.public', $this->slug);
    }

    public function isOpen(): bool
    {
        if (! $this->is_active) {
            return false;
        }
        if ($this->close_at && $this->close_at->isPast()) {
            return false;
        }
        if ($this->response_limit > 0 && $this->responses()->count() >= $this->response_limit) {
            return false;
        }

        return true;
    }

    public static function makeSlug(string $title): string
    {
        $base = \Str::slug($title) ?: 'form';
        $slug = $base;
        $i = 1;
        while (static::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.(++$i);
        }

        return $slug;
    }
}
