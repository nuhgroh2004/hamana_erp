<?php

namespace App\Modules\Recruitment\Actions;

use App\Models\User;
use App\Modules\Recruitment\Enums\JobRequestStatus;
use App\Modules\Recruitment\Models\JobRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ApproveJobRequest
{
    public function execute(JobRequest $jobRequest, string $decision, ?User $approver, ?string $notes): JobRequest
    {
        if ($jobRequest->status !== JobRequestStatus::Pending) {
            throw ValidationException::withMessages([
                'decision' => __('Permintaan ini sudah diproses sebelumnya.'),
            ]);
        }

        return DB::transaction(function () use ($jobRequest, $decision, $approver, $notes) {
            $jobRequest->update([
                'status' => $decision,
                'approved_by' => $approver?->id,
                'approved_at' => now(),
                'notes' => $notes ?? $jobRequest->notes,
            ]);

            return $jobRequest->refresh();
        });
    }
}
