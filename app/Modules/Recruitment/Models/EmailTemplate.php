<?php

namespace App\Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $table = 'recruitment_email_templates';

    protected $fillable = ['key', 'subject', 'body', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
