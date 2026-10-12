<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Recruitment\Actions\ScheduleInterview;
use App\Modules\Recruitment\Enums\InterviewType;
use App\Modules\Recruitment\Models\Application;
use App\Modules\Recruitment\Models\Interview;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->query('type');

        $items = Interview::with(['application.candidate', 'application.jobPosting', 'participants.user'])
            ->when($type, fn ($q) => $q->where('type', $type))
            ->orderByDesc('scheduled_at')
            ->paginate(15)
            ->withQueryString();

        return view('recruitment.interviews.Interviews', [
            'items' => $items,
            'type' => $type,
            'applications' => Application::where('status', 'active')
                ->with(['candidate', 'jobPosting'])
                ->get(),
            'users' => User::orderBy('name')->get(['id', 'name']),
            'interviewTypes' => InterviewType::cases(),
        ]);
    }

    public function store(Request $request, ScheduleInterview $action): RedirectResponse
    {
        $data = $request->validate([
            'application_id' => ['required', 'exists:recruitment_applications,id'],
            'type' => ['required', 'in:hr,user'],
            'scheduled_at' => ['required', 'date'],
            'duration_minutes' => ['required', 'integer', 'min:5', 'max:480'],
            'location' => ['nullable', 'string', 'max:255'],
            'participants' => ['nullable', 'array'],
            'participants.*' => ['exists:users,id'],
        ], [
            'application_id.required' => __('Lamaran wajib dipilih.'),
            'application_id.exists' => __('Lamaran tidak valid.'),
            'type.required' => __('Jenis interview wajib dipilih.'),
            'type.in' => __('Jenis interview tidak valid.'),
            'scheduled_at.required' => __('Waktu wajib diisi.'),
            'scheduled_at.date' => __('Waktu tidak valid.'),
            'duration_minutes.required' => __('Durasi wajib diisi.'),
            'duration_minutes.integer' => __('Durasi harus berupa angka.'),
            'duration_minutes.min' => __('Durasi minimal :min menit.'),
            'duration_minutes.max' => __('Durasi maksimal :max menit.'),
            'location.max' => __('Tempat maksimal :max karakter.'),
            'participants.array' => __('Pewawancara tidak valid.'),
            'participants.*.exists' => __('Pewawancara tidak valid.'),
        ], [
            'application_id' => __('Lamaran'),
            'scheduled_at' => __('Waktu interview'),
            'duration_minutes' => __('Durasi (menit)'),
            'location' => __('Tempat'),
        ]);

        $interview = Interview::create([
            'application_id' => $data['application_id'],
            'type' => $data['type'],
            'scheduled_at' => $data['scheduled_at'],
            'duration_minutes' => $data['duration_minutes'],
            'location' => $data['location'] ?? null,
            'status' => 'draft',
        ]);

        if (!empty($data['participants'])) {
            $action->attachParticipants($interview, $data['participants']);
        }

        try {
            $action->execute($interview);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $interview->delete();
            throw $e;
        }

        return back()->with('rc_msg', __('Interview berhasil dijadwalkan.'));
    }

    public function cancel(Interview $interview): RedirectResponse
    {
        $interview->update(['status' => 'cancelled']);

        return back()->with('rc_msg', __('Interview dibatalkan.'));
    }
}
