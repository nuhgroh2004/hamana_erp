<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Application;
use App\Models\Recruitment\ApplicationStageLog;
use App\Models\Recruitment\Onboarding;
use App\Models\Recruitment\Stage;
use App\Support\RekrutmenData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PipelineController extends Controller
{
    public function index()
    {
        $stages = RekrutmenData::stageRows();
        $jobs = RekrutmenData::jobs();
        $candidates = RekrutmenData::applications(
            Application::whereIn('status', ['active', 'hired'])
        );

        $nextMap = [];
        foreach ($stages as $i => $s) {
            $nextMap[$s->id] = isset($stages[$i + 1]) ? $stages[$i + 1]->id : null;
        }

        return view('sdm-dan-payroll.rekrutmen.PipelineKandidat', compact(
            'stages', 'jobs', 'candidates', 'nextMap'
        ));
    }

    public function move(Request $request, Application $application, string $stageId)
    {
        $stage = Stage::active()->findOrFail($stageId);

        if ($application->status === 'hired') {
            return response()->json(['ok' => false, 'message' => __('Kandidat sudah di-hired.')], 422);
        }

        DB::transaction(function () use ($application, $stage, $request) {
            $from = $application->current_stage_id;
            $application->update([
                'current_stage_id' => $stage->id,
                'status' => 'active',
            ]);

            ApplicationStageLog::create([
                'application_id' => $application->id,
                'from_stage_id' => $from,
                'to_stage_id' => $stage->id,
                'changed_by' => $request->user()?->id,
                'created_at' => now(),
            ]);

            if ($stage->is_final) {
                $this->hire($application);
            }
        });

        return response()->json([
            'ok' => true,
            'message' => __('Kandidat dipindah ke') . ' ' . $stage->name . '.',
        ]);
    }

    public function reject(Request $request, Application $application)
    {
        $request->validate([
            'reason_id' => ['nullable', 'exists:recruitment_rejection_reasons,id'],
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($application, $request) {
            $from = $application->current_stage_id;

            $application->update([
                'status' => 'rejected',
                'rejected_reason_id' => $request->input('reason_id'),
                'closed_at' => now(),
            ]);

            $application->candidate?->update(['is_talent_pool' => true]);

            ApplicationStageLog::create([
                'application_id' => $application->id,
                'from_stage_id' => $from,
                'to_stage_id' => null,
                'changed_by' => $request->user()?->id,
                'reason' => $request->input('reason'),
                'created_at' => now(),
            ]);
        });

        return response()->json(['ok' => true, 'message' => __('Kandidat ditolak dan masuk talent pool.')]);
    }

    public function reactivate(Request $request, Application $application)
    {
        abort_unless($application->status === 'rejected', 422);

        DB::transaction(function () use ($application, $request) {
            $application->update([
                'status' => 'active',
                'closed_at' => null,
                'rejected_reason_id' => null,
            ]);

            $application->candidate?->update(['is_talent_pool' => false]);

            ApplicationStageLog::create([
                'application_id' => $application->id,
                'from_stage_id' => null,
                'to_stage_id' => $application->current_stage_id,
                'changed_by' => $request->user()?->id,
                'created_at' => now(),
            ]);
        });

        return response()->json(['ok' => true, 'message' => __('Kandidat diaktifkan kembali.')]);
    }

    public static function hire(Application $application): void
    {
        $application->update([
            'status' => 'hired',
            'closed_at' => now(),
        ]);

        $application->candidate?->update(['is_talent_pool' => false]);

        Onboarding::ensureFor($application);
    }
}
