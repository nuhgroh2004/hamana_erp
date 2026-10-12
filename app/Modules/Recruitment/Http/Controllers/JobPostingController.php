<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Modules\Recruitment\Actions\AutoCloseJobPostings;
use App\Modules\Recruitment\Http\Requests\StoreJobPostingRequest;
use App\Modules\Recruitment\Http\Requests\UpdateJobPostingRequest;
use App\Modules\Recruitment\Models\JobPosting;
use App\Modules\Recruitment\Models\JobRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JobPostingController extends Controller
{
    public function index(Request $request, AutoCloseJobPostings $autoClose): View
    {
        $autoClose->execute();

        $status = $request->query('status');
        $items = JobPosting::with(['department', 'jobRequest'])
            ->withCount(['applications', 'applications as hired_count'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $items->getCollection()->transform(function ($jobPosting) {
            $jobPosting->hired_count = $jobPosting->applications()->where('status', 'hired')->count();

            return $jobPosting;
        });

        return view('recruitment.job-postings.JobPostings', [
            'items' => $items,
            'status' => $status,
            'statuses' => \App\Modules\Recruitment\Enums\JobPostingStatus::cases(),
        ]);
    }

    public function create(): View
    {
        return view('recruitment.job-postings.JobPostingForm', [
            'item' => null,
            'jobRequests' => JobRequest::where('status', 'approved')->with('department')->latest()->get(),
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function store(StoreJobPostingRequest $request): RedirectResponse
    {
        JobPosting::create($request->postingData() + ['status' => 'draft']);

        return redirect()
            ->route('recruitment.job-postings')
            ->with('rc_msg', __('Lowongan :title dibuat.', ['title' => $request->validated('title')]));
    }

    public function edit(JobPosting $jobPosting): View
    {
        return view('recruitment.job-postings.JobPostingForm', [
            'item' => $jobPosting,
            'jobRequests' => JobRequest::where('status', 'approved')->with('department')->latest()->get(),
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateJobPostingRequest $request, JobPosting $jobPosting): RedirectResponse
    {
        $jobPosting->update($request->postingData());

        return redirect()
            ->route('recruitment.job-postings')
            ->with('rc_msg', __('Perubahan tersimpan.'));
    }
}
