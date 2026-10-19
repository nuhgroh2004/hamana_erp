<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Application;
use App\Models\Recruitment\Interview;
use App\Support\RekrutmenData;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InterviewController extends Controller
{
    public function index()
    {
        $rows = Interview::with(['application.candidate', 'application.jobPosting', 'application.currentStage'])
            ->orderBy('scheduled_at')
            ->get()
            ->map(fn (Interview $i) => [
                'id' => $i->id,
                'waktu' => RekrutmenData::waktu($i->scheduled_at),
                'n' => $i->application?->candidate?->name ?? '—',
                'job' => $i->application?->jobPosting?->title ?? '—',
                'st' => max(0, (int) ($i->application?->currentStage?->order ?? 1) - 1),
                'edu' => $i->application?->candidate?->education ?? '—',
                'exp' => (int) ($i->application?->candidate?->experience_years ?? 0),
                'city' => $i->application?->candidate?->city ?? '—',
                'src' => $i->application?->candidate?->source?->name ?? '—',
                'note' => $i->application?->candidate?->notes ?? '',
                'jenis' => match ($i->type) {
                    'tes_praktik' => 'Tes Praktik',
                    'interview_user' => 'Interview User',
                    default => 'Interview HR',
                },
                'pewawancara' => $i->interviewer ?? ($i->type === 'tes_praktik' ? 'Kepala Produksi' : ($i->type === 'interview_user' ? 'Manajer Dept.' : 'Tim HRD')),
                'tempat' => $i->location ?? 'Ruang Meeting 1',
                'status' => $i->status,
                'statusLabel' => match ($i->status) {
                    'done' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                    default => 'Terjadwal',
                },
                'cancelUrl' => $i->status === 'scheduled' ? route('rekrutmen.jadwal.cancel', $i->id) : null,
            ])
            ->all();

        $cands = RekrutmenData::applications(
            Application::where('status', 'active')
        );

        return view('sdm-dan-payroll.rekrutmen.JadwalInterview', compact('rows', 'cands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'application_id' => ['required', 'exists:recruitment_applications,id'],
            'type' => ['required', Rule::in(['tes_praktik', 'interview_hr', 'interview_user'])],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i'],
            'duration_minutes' => ['nullable', 'integer', 'min:15', 'max:480'],
            'location' => ['nullable', 'string', 'max:255'],
            'interviewer' => ['nullable', 'string', 'max:255'],
        ]);

        Interview::create([
            'application_id' => $data['application_id'],
            'type' => $data['type'],
            'scheduled_at' => $data['date'] . ' ' . $data['time'],
            'duration_minutes' => $data['duration_minutes'] ?? 60,
            'location' => $data['location'] ?? null,
            'interviewer' => $data['interviewer'] ?? null,
            'status' => 'scheduled',
        ]);

        return response()->json(['ok' => true, 'message' => __('Jadwal interview dibuat.')]);
    }

    public function cancel(Interview $interview)
    {
        $interview->update(['status' => 'cancelled']);

        return response()->json(['ok' => true, 'message' => __('Jadwal interview dibatalkan.')]);
    }
}
