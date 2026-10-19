<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Application;
use App\Models\Recruitment\Assessment;
use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\Source;
use App\Support\RekrutmenData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CandidateController extends Controller
{
    public function index()
    {
        $candidates = RekrutmenData::applications(Application::query());
        $jobs = RekrutmenData::jobs();
        $stages = RekrutmenData::stages();
        $sources = Source::where('is_active', true)->orderBy('name')->get(['id', 'name']);
        $rkmStageTag = fn (int $st) => RekrutmenData::stageTag($st);

        return view('sdm-dan-payroll.rekrutmen.DaftarKandidat', compact(
            'candidates', 'jobs', 'stages', 'sources', 'rkmStageTag'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:32'],
            'city' => ['nullable', 'string', 'max:255'],
            'education' => ['nullable', 'string', 'max:255'],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:50'],
            'source_id' => ['nullable', 'exists:recruitment_sources,id'],
            'job_posting_id' => ['required', 'exists:recruitment_job_postings,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'score' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        DB::transaction(function () use ($data) {
            $candidate = Candidate::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'city' => $data['city'] ?? null,
                'education' => $data['education'] ?? null,
                'experience_years' => $data['experience_years'] ?? 0,
                'source_id' => $data['source_id'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);

            $application = Application::create([
                'candidate_id' => $candidate->id,
                'job_posting_id' => $data['job_posting_id'],
                'current_stage_id' => RekrutmenData::firstStageId(),
                'status' => 'active',
                'active_key' => (string) Str::uuid(),
                'applied_at' => now(),
            ]);

            if (isset($data['score']) && $data['score'] !== null) {
                Assessment::create([
                    'application_id' => $application->id,
                    'type' => 'Tes Teknis',
                    'score' => $data['score'],
                    'passed' => $data['score'] >= 75,
                    'assessed_at' => now(),
                ]);
            }
        });

        return response()->json(['ok' => true, 'message' => __('Kandidat ditambahkan ke pipeline.')]);
    }
}
