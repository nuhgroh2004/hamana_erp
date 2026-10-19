<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Application;
use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\Source;
use App\Support\RekrutmenData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TalentPoolController extends Controller
{
    public function index()
    {
        $rows = Candidate::where('is_talent_pool', true)
            ->with(['applications.jobPosting', 'applications.assessments', 'source'])
            ->latest('id')
            ->get()
            ->map(function (Candidate $c) {
                $apps = $c->applications->sortByDesc('id');
                $active = $apps->firstWhere('status', 'active');
                $job = $active?->jobPosting?->title
                    ?? $apps->first()?->jobPosting?->title
                    ?? ($c->talent_tags[0] ?? '—');
                $score = (int) $apps->flatMap->assessments->max('score');

                return [
                    'cid' => $c->id,
                    'app' => $active?->id,
                    'st' => $active ? max(0, (int) ($active->currentStage?->order ?? 1) - 1) : -1,
                    'n' => $c->name,
                    'job' => $job,
                    'edu' => $c->education ?? '—',
                    'exp' => (int) $c->experience_years,
                    'city' => $c->city ?? '—',
                    'src' => $c->source?->name ?? '—',
                    'sc' => $score,
                    'note' => $c->notes ?? '',
                ];
            })
            ->all();

        $jobs = array_values(array_filter(RekrutmenData::jobs(), fn ($j) => $j['statusRaw'] === 'active'));
        $sources = Source::where('is_active', true)->orderBy('name')->get(['id', 'name']);

        return view('sdm-dan-payroll.rekrutmen.TalentPool', compact('rows', 'jobs', 'sources'));
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
            'skill' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Candidate::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'city' => $data['city'] ?? null,
            'education' => $data['education'] ?? null,
            'experience_years' => $data['experience_years'] ?? 0,
            'source_id' => $data['source_id'] ?? null,
            'notes' => $data['notes'] ?? null,
            'is_talent_pool' => true,
            'talent_tags' => array_values(array_filter([$data['skill'] ?? null])),
        ]);

        return response()->json(['ok' => true, 'message' => __('Talenta ditambahkan ke talent pool.')]);
    }

    public function addToPipeline(Request $request, Candidate $candidate)
    {
        $data = $request->validate([
            'job_posting_id' => ['required', 'exists:recruitment_job_postings,id'],
        ]);

        $exists = Application::where('candidate_id', $candidate->id)
            ->where('job_posting_id', $data['job_posting_id'])
            ->where('status', 'active')
            ->exists();

        if ($exists) {
            return response()->json(['ok' => false, 'message' => __('Kandidat sudah melamar di lowongan tersebut.')], 422);
        }

        DB::transaction(function () use ($candidate, $data) {
            Application::create([
                'candidate_id' => $candidate->id,
                'job_posting_id' => $data['job_posting_id'],
                'current_stage_id' => RekrutmenData::firstStageId(),
                'status' => 'active',
                'active_key' => (string) Str::uuid(),
                'applied_at' => now(),
            ]);

            $candidate->update(['is_talent_pool' => false]);
        });

        return response()->json(['ok' => true, 'message' => __('Kandidat masuk pipeline.')]);
    }

    public function remove(Candidate $candidate)
    {
        $candidate->update(['is_talent_pool' => false]);

        return response()->json(['ok' => true, 'message' => __('Kandidat dikeluarkan dari talent pool.')]);
    }
}
