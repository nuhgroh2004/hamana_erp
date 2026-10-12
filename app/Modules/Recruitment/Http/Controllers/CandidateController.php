<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recruitment\Http\Requests\CandidateFormRequest;
use App\Modules\Recruitment\Models\Candidate;
use App\Modules\Recruitment\Models\JobPosting;
use App\Modules\Recruitment\Models\Source;
use App\Modules\Recruitment\Models\Stage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->query('q');
        $jobPostingId = $request->query('job_posting_id');
        $stageId = $request->query('stage_id');

        $items = Candidate::with('source')
            ->when($q, fn ($c) => $c->where(fn ($w) => $w
                ->where('name', 'like', "%{$q}%")
                ->orWhere('city', 'like', "%{$q}%")))
            ->when($jobPostingId, fn ($c) => $c->whereHas('applications', fn ($a) => $a->where('job_posting_id', $jobPostingId)))
            ->when($stageId, fn ($c) => $c->whereHas('applications', fn ($a) => $a->where('current_stage_id', $stageId)))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('recruitment.candidates.Candidates', [
            'items' => $items,
            'q' => $q,
            'jobPostingId' => $jobPostingId,
            'stageId' => $stageId,
            'jobPostings' => JobPosting::orderBy('title')->get(),
            'stages' => Stage::active()->get(),
        ]);
    }

    public function create(): View
    {
        return view('recruitment.candidates.CandidateForm', [
            'item' => null,
            'sources' => Source::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(CandidateFormRequest $request): RedirectResponse
    {
        $candidate = Candidate::create($request->validated());

        return redirect()
            ->route('recruitment.candidates.show', $candidate)
            ->with('rc_msg', __('Kandidat :name dibuat.', ['name' => $candidate->name]));
    }

    public function show(Candidate $candidate): View
    {
        $candidate->load([
            'source', 'documents',
            'applications.jobPosting',
            'applications.currentStage',
            'applications.stageLogs.fromStage',
            'applications.stageLogs.toStage',
            'applications.stageLogs.changer',
            'applications.assessments.assessor',
            'applications.interviews.participants.user',
            'applications.interviews.scores.scorer',
        ]);

        return view('recruitment.candidates.CandidateDetail', ['item' => $candidate]);
    }

    public function edit(Candidate $candidate): View
    {
        return view('recruitment.candidates.CandidateForm', [
            'item' => $candidate,
            'sources' => Source::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function update(CandidateFormRequest $request, Candidate $candidate): RedirectResponse
    {
        $candidate->update($request->validated());

        return redirect()
            ->route('recruitment.candidates.show', $candidate)
            ->with('rc_msg', __('Perubahan tersimpan.'));
    }
}
