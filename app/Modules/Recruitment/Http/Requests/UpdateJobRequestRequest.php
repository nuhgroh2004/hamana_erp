<?php

namespace App\Modules\Recruitment\Http\Requests;

use App\Modules\Recruitment\Enums\JobRequestStatus;
use App\Modules\Recruitment\Models\JobRequest;

class UpdateJobRequestRequest extends JobRequestFormRequest
{
    public function authorize(): bool
    {
        $jobRequest = $this->route('jobRequest');

        return $jobRequest instanceof JobRequest && $jobRequest->status === JobRequestStatus::Pending;
    }
}
