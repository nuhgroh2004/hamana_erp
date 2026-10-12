<?php

namespace App\Modules\Recruitment\Actions;

use App\Modules\Recruitment\Enums\JobRequestStatus;
use App\Modules\Recruitment\Models\JobRequest;
use Illuminate\Validation\ValidationException;

class CancelJobRequest
{
    public function execute(JobRequest $jobRequest): JobRequest
    {
        if ($jobRequest->status !== JobRequestStatus::Pending) {
            throw ValidationException::withMessages([
                'job_request' => __('Hanya permintaan berstatus Menunggu yang bisa dibatalkan.'),
            ]);
        }

        $jobRequest->update(['status' => JobRequestStatus::Cancelled->value]);

        return $jobRequest->refresh();
    }
}
