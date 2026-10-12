<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recruitment\Models\Application;
use App\Modules\Recruitment\Models\Candidate;
use App\Modules\Recruitment\Models\Offer;
use App\Modules\Recruitment\Models\Stage;
use Illuminate\Contracts\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $bySource = Candidate::selectRaw('source_id, count(*) as total')
            ->groupBy('source_id')
            ->with('source')
            ->get()
            ->mapWithKeys(fn ($row) => [($row->source?->name ?? __('Tanpa sumber')) => $row->total])
            ->sortDesc();

        $byStage = Stage::orderBy('order')->get()->mapWithKeys(fn ($s) => [
            $s->name => Application::where('current_stage_id', $s->id)->where('status', 'active')->count(),
        ]);

        $hired = Application::where('status', 'hired')
            ->whereNotNull('closed_at')
            ->where('applied_at', '>=', now()->subMonths(12))
            ->get();

        $timeToHire = $hired->avg(fn ($a) => $a->applied_at->diffInDays($a->closed_at));

        $offerTotals = Offer::selectRaw("
            count(*) as total,
            sum(case when status = 'accepted' then 1 else 0 end) as accepted
        ")->first();

        $acceptanceRate = $offerTotals && $offerTotals->total > 0
            ? round($offerTotals->accepted / $offerTotals->total * 100, 1)
            : 0;

        return view('recruitment.reports.Reports', [
            'bySource' => $bySource,
            'byStage' => $byStage,
            'avgTimeToHire' => $timeToHire !== null ? round($timeToHire, 1) : null,
            'offerTotal' => (int) ($offerTotals?->total ?? 0),
            'offerAccepted' => (int) ($offerTotals?->accepted ?? 0),
            'acceptanceRate' => $acceptanceRate,
            'hiredThisMonth' => $hired->filter(fn ($a) => $a->closed_at->isCurrentMonth())->count(),
        ]);
    }
}
