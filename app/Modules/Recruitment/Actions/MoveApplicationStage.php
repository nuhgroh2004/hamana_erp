<?php

namespace App\Modules\Recruitment\Actions;

use App\Models\User;
use App\Modules\Recruitment\Models\Application;
use App\Modules\Recruitment\Models\ApplicationStageLog;
use App\Modules\Recruitment\Models\Stage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MoveApplicationStage
{
    public function execute(Application $application, Stage $target, ?User $user, ?string $reason = null): Application
    {
        return DB::transaction(function () use ($application, $target, $user, $reason) {
            if ($application->status->value !== 'active') {
                throw ValidationException::withMessages([
                    'stage' => __('Lamaran sudah ditutup.'),
                ]);
            }

            $current = $application->currentStage;
            if ($current && $current->id === $target->id) {
                throw ValidationException::withMessages([
                    'stage' => __('Kandidat sudah berada di tahap tersebut.'),
                ]);
            }

            $application->update(['current_stage_id' => $target->id]);

            ApplicationStageLog::create([
                'application_id' => $application->id,
                'from_stage_id' => $current?->id,
                'to_stage_id' => $target->id,
                'changed_by' => $user?->id,
                'reason' => $reason,
            ]);

            return $application;
        });
    }
}
