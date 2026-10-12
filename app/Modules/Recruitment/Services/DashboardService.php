<?php

namespace App\Modules\Recruitment\Services;

use App\Modules\Recruitment\Models\Application;
use App\Modules\Recruitment\Models\ApplicationStageLog;
use App\Modules\Recruitment\Models\Candidate;
use App\Modules\Recruitment\Models\Interview;
use App\Modules\Recruitment\Models\JobPosting;
use App\Modules\Recruitment\Models\Offer;
use App\Modules\Recruitment\Models\Stage;
use Illuminate\Support\Collection;

class DashboardService
{
    public function kpis(): array
    {
        $now = now();
        $avgDays = Application::where('status', 'hired')
            ->whereNotNull('closed_at')
            ->selectRaw('AVG(DATEDIFF(closed_at, applied_at)) as avg_days')
            ->value('avg_days');

        return [
            'active_postings' => JobPosting::where('status', 'active')->count(),
            'total_candidates' => Candidate::count(),
            'interviews_this_week' => Interview::where('status', '!=', 'cancelled')
                ->whereBetween('scheduled_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()])
                ->count(),
            'pending_offers' => Offer::whereIn('status', ['pending_approval', 'approved', 'sent'])->count(),
            'hired_this_month' => Application::where('status', 'hired')
                ->where('closed_at', '>=', $now->copy()->startOfMonth())
                ->count(),
            'avg_time_to_hire' => (int) round((float) $avgDays),
        ];
    }

    public function funnel(): Collection
    {
        return Stage::active()->withCount([
            'applications as count' => fn ($q) => $q->where('status', 'active'),
        ])->get();
    }

    public function recentActivity(): Collection
    {
        return ApplicationStageLog::with(['application.candidate', 'toStage', 'changer'])
            ->latest('created_at')
            ->limit(10)
            ->get();
    }
}
