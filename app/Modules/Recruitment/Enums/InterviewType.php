<?php

namespace App\Modules\Recruitment\Enums;

enum InterviewType: string
{
    case Hr = 'hr';
    case User = 'user';

    public function label(): string
    {
        return match ($this) {
            self::Hr => __('Interview HR'),
            self::User => __('Interview User'),
        };
    }
}
