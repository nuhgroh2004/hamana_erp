<?php

namespace App\Modules\Recruitment\Actions;

use App\Models\User;
use App\Modules\Recruitment\Models\Application;
use App\Modules\Recruitment\Models\ApplicationStageLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RejectApplication
{
    public function execute(Application $application, int $reasonId, ?User $user, ?string $notes = null): Application
    {
        return DB::transaction(function () use ($application, $reasonId, $user, $notes) {
            if ($application->status->value !== 'active') {
                throw ValidationException::withMessages([
                    'reason_id' => __('Lamaran sudah ditutup.'),
                ]);
            }

            $application->update([
                'status' => 'rejected',
                'rejected_reason_id' => $reasonId,
                'closed_at' => now(),
                'active_key' => null,
            ]);

            ApplicationStageLog::create([
                'application_id' => $application->id,
                'from_stage_id' => $application->current_stage_id,
                'to_stage_id' => $application->current_stage_id,
                'changed_by' => $user?->id,
                'reason' => $notes,
            ]);

            return $application;
        });
    }
}
