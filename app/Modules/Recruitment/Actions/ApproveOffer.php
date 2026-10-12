<?php

namespace App\Modules\Recruitment\Actions;

use App\Models\User;
use App\Modules\Recruitment\Models\Offer;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ApproveOffer
{
    public function execute(Offer $offer, ?User $approver): Offer
    {
        return DB::transaction(function () use ($offer, $approver) {
            if ($offer->status->value !== 'pending_approval') {
                throw ValidationException::withMessages([
                    'status' => __('Penawaran tidak dalam status menunggu persetujuan.'),
                ]);
            }

            $offer->update([
                'status' => 'approved',
                'approved_by' => $approver?->id,
            ]);

            return $offer;
        });
    }
}
