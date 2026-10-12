<?php

namespace App\Modules\Recruitment\Enums;

enum JobPostingStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::Draft => __('Draft'),
            self::Active => __('Aktif'),
            self::Closed => __('Ditutup'),
        };
    }

    public function chipClass(): string
    {
        return match ($this) {
            self::Draft => 'rc-chip rc-chip-amber',
            self::Active => 'rc-chip rc-chip-teal',
            self::Closed => 'rc-chip rc-chip-mut',
        };
    }
}
