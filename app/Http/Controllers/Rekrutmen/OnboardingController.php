<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Application;
use App\Models\Recruitment\OnboardingTask;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index()
    {
        $hired = Application::where('status', 'hired')
            ->with(['candidate', 'jobPosting', 'offer', 'onboarding.tasks'])
            ->orderByDesc('closed_at')
            ->get();

        foreach ($hired as $a) {
            \App\Models\Recruitment\Onboarding::ensureFor($a);
        }

        $hired->load('onboarding.tasks');

        $cards = $hired->map(fn (Application $a) => [
            'app' => $a->id,
            'n' => $a->candidate?->name ?? '—',
            'job' => $a->jobPosting?->title ?? '—',
            'start' => $a->offer?->start_date?->format('j M Y') ?? $a->onboarding?->start_date?->format('j M Y') ?? '—',
            'done' => (int) $a->onboarding?->tasks->where('is_done', true)->count(),
            'total' => (int) $a->onboarding?->tasks->count(),
            'tasks' => $a->onboarding?->tasks->map(fn ($t) => [
                'id' => $t->id,
                'title' => $t->title,
                'done' => (bool) $t->is_done,
            ])->all() ?? [],
        ])->all();

        return view('sdm-dan-payroll.rekrutmen.Onboarding', ['cards' => $cards]);
    }

    public function toggleTask(Request $request, OnboardingTask $task)
    {
        $data = $request->validate([
            'done' => ['required', 'boolean'],
        ]);

        $done = (bool) $data['done'];

        $task->update([
            'is_done' => $done,
            'done_by' => $done ? $request->user()?->id : null,
            'done_at' => $done ? now() : null,
        ]);

        return response()->json([
            'ok' => true,
            'message' => $done ? __('Tugas ditandai selesai.') : __('Tugas dibuka kembali.'),
        ]);
    }
}
