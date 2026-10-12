<?php

namespace App\Modules\Recruitment\Enums;

enum ApplicationStatus: string
{
    case Active = 'active';
    case Rejected = 'rejected';
    case Hired = 'hired';
    case Withdrawn = 'withdrawn';

    public function label(): string
    {
        return match ($this) {
            self::Active => __('Aktif'),
            self::Rejected => __('Ditolak'),
            self::Hired => __('Diterima'),
            self::Withdrawn => __('Ditarik'),
        };
    }

    public function chipClass(): string
    {
        return match ($this) {
            self::Active => 'rc-chip rc-chip-teal',
            self::Rejected => 'rc-chip rc-chip-red',
            self::Hired => 'rc-chip rc-chip-purple',
            self::Withdrawn => 'rc-chip rc-chip-mut',
        };
    }
}
