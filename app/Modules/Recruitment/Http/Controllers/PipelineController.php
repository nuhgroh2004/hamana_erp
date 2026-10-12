<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recruitment\Actions\MoveApplicationStage;
use App\Modules\Recruitment\Actions\RejectApplication;
use App\Modules\Recruitment\Models\Application;
use App\Modules\Recruitment\Models\JobPosting;
use App\Modules\Recruitment\Models\RejectionReason;
use App\Modules\Recruitment\Models\Stage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PipelineController extends Controller
{
    public function index(Request $request): View
    {
        $jobPostingId = $request->query('job_posting_id');

        $stages = Stage::active()->get();

        $applications = Application::with(['candidate', 'jobPosting', 'currentStage'])
            ->where('status', 'active')
            ->when($jobPostingId, fn ($q) => $q->where('job_posting_id', $jobPostingId))
            ->get()
            ->groupBy('current_stage_id');

        return view('recruitment.pipeline.Pipeline', [
            'stages' => $stages,
            'applications' => $applications,
            'jobPostingId' => $jobPostingId,
            'jobPostings' => JobPosting::orderBy('title')->get(),
            'rejectionReasons' => RejectionReason::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function move(Request $request, Application $application, MoveApplicationStage $action): RedirectResponse
    {
        $data = $request->validate([
            'stage_id' => ['required', 'exists:recruitment_stages,id'],
            'reason' => ['nullable', 'string', 'max:1000'],
        ], [
            'stage_id.required' => __('Tahap wajib dipilih.'),
            'stage_id.exists' => __('Tahap tidak valid.'),
        ]);

        $stage = Stage::findOrFail($data['stage_id']);

        $action->execute($application, $stage, $request->user(), $data['reason'] ?? null);

        return back()->with('rc_msg', __('Kandidat dipindah ke tahap :stage.', ['stage' => $stage->name]));
    }

    public function reject(Request $request, Application $application, RejectApplication $action): RedirectResponse
    {
        $data = $request->validate([
            'reason_id' => ['required', 'exists:recruitment_rejection_reasons,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'reason_id.required' => __('Alasan tolak wajib dipilih.'),
            'reason_id.exists' => __('Alasan tolak tidak valid.'),
        ]);

        $action->execute($application, (int) $data['reason_id'], $request->user(), $data['notes'] ?? null);

        return back()->with('rc_msg', __('Lamaran ditolak.'));
    }
}
