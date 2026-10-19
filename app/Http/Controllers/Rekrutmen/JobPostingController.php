<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Recruitment\JobPosting;
use App\Support\RekrutmenData;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobPostingController extends Controller
{
    public function index()
    {
        $jobs = RekrutmenData::jobs();
        $departments = Department::orderBy('name')->get(['id', 'name']);
        $rkmJobTag = fn (string $status) => RekrutmenData::jobTag($status);

        return view('sdm-dan-payroll.rekrutmen.Lowongan', compact('jobs', 'departments', 'rkmJobTag'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'location' => ['nullable', 'string', 'max:255'],
            'quota' => ['required', 'integer', 'min:1', 'max:999'],
            'deadline' => ['nullable', 'date'],
            'priority' => ['required', Rule::in(['normal', 'tinggi'])],
            'status' => ['required', Rule::in(['draft', 'active', 'closed'])],
        ]);

        $job = JobPosting::create($data + [
            'published_at' => $data['status'] === 'active' ? now() : null,
            'closed_at' => $data['status'] === 'closed' ? now() : null,
        ]);

        return response()->json([
            'ok' => true,
            'message' => $job->status === 'active'
                ? __('Lowongan dipublikasikan.')
                : __('Lowongan dibuat.'),
        ]);
    }

    public function updateStatus(Request $request, JobPosting $jobPosting, string $status)
    {
        abort_unless(in_array($status, ['draft', 'active', 'closed'], true), 422);

        $updates = ['status' => $status];

        if ($status === 'active' && ! $jobPosting->published_at) {
            $updates['published_at'] = now();
        }
        if ($status === 'closed') {
            $updates['closed_at'] = now();
        }
        if ($status !== 'closed') {
            $updates['closed_at'] = null;
        }

        $jobPosting->update($updates);

        $message = match ($status) {
            'active' => __('Lowongan dipublikasikan.'),
            'closed' => __('Lowongan ditutup.'),
            default => __('Lowongan dikembalikan ke draft.'),
        };

        return response()->json(['ok' => true, 'message' => $message]);
    }
}
