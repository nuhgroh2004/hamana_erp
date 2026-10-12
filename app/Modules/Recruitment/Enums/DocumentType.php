<?php

namespace App\Modules\Recruitment\Enums;

enum DocumentType: string
{
    case Cv = 'cv';
    case Ktp = 'ktp';
    case Ijazah = 'ijazah';
    case Sertifikat = 'sertifikat';

    public function label(): string
    {
        return match ($this) {
            self::Cv => 'CV',
            self::Ktp => 'KTP',
            self::Ijazah => __('Ijazah'),
            self::Sertifikat => __('Sertifikat'),
        };
    }
}
