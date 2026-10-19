<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Application;
use App\Models\Recruitment\ApplicationStageLog;
use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\Interview;
use App\Models\Recruitment\JobPosting;
use App\Models\Recruitment\Offer;
use App\Support\RekrutmenData;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $rkm = RekrutmenData::all();

        $candidates = $rkm['candidates'];
        $activeCands = array_values(array_filter($candidates, fn ($c) => $c['st'] >= 0));

        $funnel = [];
        foreach ($rkm['stages'] as $i => $s) {
            $funnel[] = ['label' => $s, 'n' => count(array_filter($activeCands, fn ($c) => $c['st'] >= $i))];
        }
        $funnelMax = $funnel ? max(array_column($funnel, 'n')) : 0;

        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        $hiredApps = Application::where('status', 'hired')
            ->whereNotNull('applied_at')
            ->whereNotNull('closed_at')
            ->get();
        $avgDays = $hiredApps->count()
            ? (int) round($hiredApps->avg(fn ($a) => $a->applied_at->diffInDays($a->closed_at)))
            : null;

        $stats = [
            'lowonganAktif' => JobPosting::where('status', 'active')->count(),
            'kandidat' => Candidate::count(),
            'interviewMinggu' => Interview::where('status', 'scheduled')
                ->whereBetween('scheduled_at', [$weekStart, $weekEnd])
                ->count(),
            'offerPending' => Offer::whereIn('status', ['pending_approval', 'sent'])->count(),
            'hiredBulan' => Application::where('status', 'hired')
                ->where('closed_at', '>=', Carbon::now()->startOfMonth())
                ->count(),
            'tth' => $avgDays !== null ? $avgDays . ' ' . __('hari') : '—',
        ];

        $aktivitas = ApplicationStageLog::with(['application.candidate', 'toStage'])
            ->latest('created_at')
            ->limit(6)
            ->get()
            ->map(function (ApplicationStageLog $log) {
                $name = $log->application?->candidate?->name ?? __('Kandidat');
                $target = $log->toStage?->name ?? '';
                $text = $target
                    ? $name . ' — ' . __('masuk tahap') . ' ' . $target
                    : $name . ' — ' . __('melamar');

                return [$text, $log->created_at?->diffForHumans() ?? ''];
            })
            ->all();

        return view('sdm-dan-payroll.rekrutmen.Rekrutmen', compact(
            'rkm', 'funnel', 'funnelMax', 'stats', 'aktivitas'
        ));
    }
}
