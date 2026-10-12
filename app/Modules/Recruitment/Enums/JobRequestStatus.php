<?php

namespace App\Modules\Recruitment\Enums;

enum JobRequestStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => __('Menunggu'),
            self::Approved => __('Disetujui'),
            self::Rejected => __('Ditolak'),
            self::Cancelled => __('Dibatalkan'),
        };
    }

    public function chipClass(): string
    {
        return match ($this) {
            self::Pending => 'rc-chip rc-chip-amber',
            self::Approved => 'rc-chip rc-chip-teal',
            self::Rejected => 'rc-chip rc-chip-red',
            self::Cancelled => 'rc-chip rc-chip-mut',
        };
    }
}
