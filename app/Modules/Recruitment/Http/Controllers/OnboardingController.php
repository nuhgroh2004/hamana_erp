<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recruitment\Models\Onboarding;
use App\Modules\Recruitment\Models\OnboardingTask;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $items = Onboarding::with(['application.candidate', 'application.jobPosting', 'employee', 'tasks.doer'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderByDesc('start_date')
            ->paginate(15)
            ->withQueryString();

        return view('recruitment.onboarding.Onboarding', [
            'items' => $items,
            'status' => $status,
        ]);
    }

    public function toggleTask(OnboardingTask $task): RedirectResponse
    {
        $task->update([
            'is_done' => !$task->is_done,
            'done_by' => $task->is_done ? null : request()->user()?->id,
            'done_at' => $task->is_done ? null : now(),
        ]);

        return back()->with('rc_msg', __('Tugas diperbarui.'));
    }

    public function complete(Onboarding $onboarding): RedirectResponse
    {
        $pending = $onboarding->tasks()->where('is_done', false)->count();

        if ($pending > 0) {
            return back()->with('rc_errors', __('Masih ada :count tugas yang belum selesai.', ['count' => $pending]));
        }

        $onboarding->update(['status' => 'done']);

        return back()->with('rc_msg', __('Onboarding selesai.'));
    }
}
