<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recruitment\Actions\ApproveJobRequest;
use App\Modules\Recruitment\Models\JobRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JobRequestApprovalController extends Controller
{
    public function __invoke(Request $request, JobRequest $jobRequest, ApproveJobRequest $action): RedirectResponse
    {
        $data = $request->validate([
            'decision' => ['required', 'in:approved,rejected'],
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'decision.required' => __('Keputusan wajib dipilih.'),
            'decision.in' => __('Keputusan tidak valid.'),
            'notes.max' => __('Catatan maksimal 500 karakter.'),
        ]);

        $jobRequest = $action->execute($jobRequest, $data['decision'], $request->user(), $data['notes'] ?? null);

        return back()->with('rc_msg', __('Permintaan :code :status.', [
            'code' => $jobRequest->code,
            'status' => $jobRequest->status->label(),
        ]));
    }
}
