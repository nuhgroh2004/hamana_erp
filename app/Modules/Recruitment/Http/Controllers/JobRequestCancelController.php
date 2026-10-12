<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recruitment\Actions\CancelJobRequest;
use App\Modules\Recruitment\Models\JobRequest;
use Illuminate\Http\RedirectResponse;

class JobRequestCancelController extends Controller
{
    public function __invoke(JobRequest $jobRequest, CancelJobRequest $action): RedirectResponse
    {
        $action->execute($jobRequest);

        return back()->with('rc_msg', __('Permintaan :code :status.', [
            'code' => $jobRequest->code,
            'status' => $jobRequest->status->label(),
        ]));
    }
}
