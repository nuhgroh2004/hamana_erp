<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Application;
use App\Models\Recruitment\Offer;
use App\Models\Recruitment\Stage;
use App\Support\RekrutmenData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function index()
    {
        $rows = Application::with(['candidate', 'jobPosting', 'currentStage', 'offer'])
            ->whereHas('currentStage', fn ($q) => $q->where('order', '>=', 6))
            ->orderByDesc('id')
            ->get()
            ->map(function (Application $a) {
                $offer = $a->offer;
                $respondable = $offer && in_array($offer->status, ['pending_approval', 'sent', 'approved'], true);

                return [
                    'app' => $a->id,
                    'offer' => $offer?->id,
                    'n' => $a->candidate?->name ?? '—',
                    'job' => $a->jobPosting?->title ?? '—',
                    'st' => max(0, (int) ($a->currentStage?->order ?? 1) - 1),
                    'edu' => $a->candidate?->education ?? '—',
                    'exp' => (int) ($a->candidate?->experience_years ?? 0),
                    'city' => $a->candidate?->city ?? '—',
                    'src' => $a->candidate?->source?->name ?? '—',
                    'sc' => 0,
                    'note' => $a->candidate?->notes ?? '',
                    'gaji' => $offer ? $offer->base_salary : null,
                    'tunjangan' => $offer ? ($offer->allowance ?? 0) : null,
                    'mulai' => $offer ? RekrutmenData::tgl($offer->start_date) : '—',
                    'status' => $offer ? self::statusLabel($offer->status) : 'Belum dibuat',
                    'statusKey' => $offer?->status ?? 'none',
                    'statusCls' => self::statusCls($offer?->status ?? 'none'),
                    'sendUrl' => $offer && in_array($offer->status, ['pending_approval', 'approved'], true)
                        ? route('rekrutmen.penawaran.send', $offer->id) : null,
                    'acceptUrl' => $respondable ? route('rekrutmen.penawaran.accept', $offer->id) : null,
                    'declineUrl' => $respondable ? route('rekrutmen.penawaran.decline', $offer->id) : null,
                ];
            })
            ->all();

        $cands = RekrutmenData::applications(
            Application::where('status', 'active')
                ->whereHas('currentStage', fn ($q) => $q->where('order', '>=', 5))
        );

        return view('sdm-dan-payroll.rekrutmen.PenawaranKerja', compact('rows', 'cands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'application_id' => ['required', 'exists:recruitment_applications,id'],
            'base_salary' => ['required', 'numeric', 'min:0', 'max:999999999999'],
            'allowance' => ['nullable', 'numeric', 'min:0', 'max:999999999999'],
            'start_date' => ['required', 'date'],
            'valid_until' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        $application = Application::with('currentStage')->findOrFail($data['application_id']);

        if ($application->status !== 'active') {
            return response()->json(['ok' => false, 'message' => __('Kandidat tidak aktif.')], 422);
        }

        if ($application->offer) {
            return response()->json(['ok' => false, 'message' => __('Penawaran untuk kandidat ini sudah ada.')], 422);
        }

        Offer::create([
            'application_id' => $application->id,
            'base_salary' => $data['base_salary'],
            'allowance' => $data['allowance'] ?? 0,
            'start_date' => $data['start_date'],
            'valid_until' => $data['valid_until'] ?? now()->addDays(14)->toDateString(),
            'status' => 'pending_approval',
        ]);

        if (($application->currentStage?->order ?? 0) < 6) {
            $application->update(['current_stage_id' => Stage::active()->where('order', 6)->value('id') ?: $application->current_stage_id]);
        }

        return response()->json(['ok' => true, 'message' => __('Penawaran kerja dibuat dan menunggu persetujuan.')]);
    }

    public function send(Request $request, Offer $offer)
    {
        abort_unless(in_array($offer->status, ['pending_approval', 'approved'], true), 422);

        $offer->update([
            'status' => 'sent',
            'approved_by' => $request->user()?->id,
        ]);

        return response()->json(['ok' => true, 'message' => __('Penawaran disetujui dan dikirim ke kandidat.')]);
    }

    public function accept(Offer $offer)
    {
        abort_unless(in_array($offer->status, ['pending_approval', 'sent', 'approved'], true), 422);

        DB::transaction(function () use ($offer) {
            $offer->update([
                'status' => 'accepted',
                'responded_at' => now(),
            ]);

            $application = $offer->application()->with('candidate')->firstOrFail();

            $hiredStage = Stage::active()->where('is_final', true)->first()
                ?? Stage::active()->orderByDesc('order')->first();
            $application->update(['current_stage_id' => $hiredStage?->id ?? $application->current_stage_id]);

            \App\Http\Controllers\Rekrutmen\PipelineController::hire($application);
        });

        return response()->json(['ok' => true, 'message' => __('Penawaran diterima — kandidat di-hired.')]);
    }

    public function decline(Offer $offer)
    {
        abort_unless(in_array($offer->status, ['pending_approval', 'sent', 'approved'], true), 422);

        $offer->update([
            'status' => 'declined',
            'responded_at' => now(),
        ]);

        return response()->json(['ok' => true, 'message' => __('Penawaran ditolak kandidat.')]);
    }

    private static function statusLabel(?string $status): string
    {
        return match ($status) {
            'draft' => 'Draft',
            'pending_approval' => 'Menunggu',
            'approved' => 'Disetujui',
            'sent' => 'Terkirim',
            'accepted' => 'Diterima',
            'declined' => 'Ditolak',
            default => '—',
        };
    }

    private static function statusCls(?string $status): string
    {
        return match ($status) {
            'accepted' => 'g',
            'declined' => 'r',
            'sent' => 'b',
            'approved' => 'b',
            'pending_approval' => 'y',
            default => 'n',
        };
    }
}
