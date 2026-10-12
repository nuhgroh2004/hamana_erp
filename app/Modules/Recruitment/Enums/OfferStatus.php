<?php

namespace App\Modules\Recruitment\Enums;

enum OfferStatus: string
{
    case Draft = 'draft';
    case PendingApproval = 'pending_approval';
    case Approved = 'approved';
    case Sent = 'sent';
    case Accepted = 'accepted';
    case Declined = 'declined';

    public function label(): string
    {
        return match ($this) {
            self::Draft => __('Draft'),
            self::PendingApproval => __('Menunggu Persetujuan'),
            self::Approved => __('Disetujui'),
            self::Sent => __('Terkirim'),
            self::Accepted => __('Diterima'),
            self::Declined => __('Ditolak'),
        };
    }
}
