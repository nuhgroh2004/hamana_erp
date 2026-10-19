<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormField extends Model
{
    protected $table = 'recruitment_form_fields';

    protected $fillable = [
        'form_id', 'type', 'label', 'help', 'options',
        'file_types', 'max_mb', 'is_required', 'ord',
    ];

    protected function casts(): array
    {
        return [
            'options' => 'array',
            'file_types' => 'array',
            'is_required' => 'boolean',
        ];
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public const TYPES = [
        'text' => 'Teks Pendek',
        'long' => 'Paragraf',
        'num' => 'Angka',
        'date' => 'Tanggal',
        'enum' => 'Dropdown (Enum)',
        'radio' => 'Pilihan Tunggal',
        'check' => 'Kotak Centang',
        'file' => 'Upload File (PDF / JPG)',
    ];

    public const TYPE_ICONS = [
        'text' => 'short_text',
        'long' => 'notes',
        'num' => 'pin',
        'date' => 'calendar_today',
        'enum' => 'arrow_drop_down_circle',
        'radio' => 'radio_button_checked',
        'check' => 'check_box',
        'file' => 'upload_file',
    ];
}
