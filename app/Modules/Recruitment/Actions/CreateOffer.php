<?php

namespace App\Modules\Recruitment\Actions;

use App\Modules\Recruitment\Models\Application;
use App\Modules\Recruitment\Models\Offer;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreateOffer
{
    public function execute(Application $application, array $data): Offer
    {
        return DB::transaction(function () use ($application, $data) {
            $exists = Offer::where('application_id', $application->id)
                ->whereIn('status', ['draft', 'pending_approval', 'approved', 'sent'])
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'application_id' => __('Penawaran aktif sudah ada untuk lamaran ini.'),
                ]);
            }

            return Offer::create($data + [
                'application_id' => $application->id,
                'status' => 'pending_approval',
            ]);
        });
    }
}
