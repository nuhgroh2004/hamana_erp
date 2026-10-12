<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Position;
use App\Modules\Recruitment\Actions\SubmitJobRequest;
use App\Modules\Recruitment\Enums\JobRequestStatus;
use App\Modules\Recruitment\Http\Requests\StoreJobRequestRequest;
use App\Modules\Recruitment\Http\Requests\UpdateJobRequestRequest;
use App\Modules\Recruitment\Models\JobRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JobRequestController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $items = JobRequest::with(['department', 'position', 'requester'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('recruitment.job-requests.JobRequests', [
            'items' => $items,
            'status' => $status,
            'statuses' => JobRequestStatus::cases(),
        ]);
    }

    public function create(): View
    {
        return view('recruitment.job-requests.JobRequestForm', [
            'item' => null,
            'departments' => Department::orderBy('name')->get(),
            'positions' => Position::with('department')->orderBy('name')->get(),
        ]);
    }

    public function store(StoreJobRequestRequest $request, SubmitJobRequest $action): RedirectResponse
    {
        $jobRequest = $action->execute($request->validated(), $request->user());

        return redirect()
            ->route('recruitment.job-requests')
            ->with('rc_msg', __('Permintaan :code berhasil dibuat.', ['code' => $jobRequest->code]));
    }

    public function edit(JobRequest $jobRequest): View
    {
        abort_unless($jobRequest->status === JobRequestStatus::Pending, 403);

        return view('recruitment.job-requests.JobRequestForm', [
            'item' => $jobRequest,
            'departments' => Department::orderBy('name')->get(),
            'positions' => Position::with('department')->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateJobRequestRequest $request, JobRequest $jobRequest): RedirectResponse
    {
        $jobRequest->update($request->validated());

        return redirect()
            ->route('recruitment.job-requests')
            ->with('rc_msg', __('Perubahan tersimpan.'));
    }
}
