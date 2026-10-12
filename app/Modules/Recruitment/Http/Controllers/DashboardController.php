<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recruitment\Services\DashboardService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardService $dashboard)
    {
    }

    public function __invoke(): View
    {
        return view('recruitment.dashboard.Dashboard', [
            'kpis' => $this->dashboard->kpis(),
            'funnel' => $this->dashboard->funnel(),
            'activity' => $this->dashboard->recentActivity(),
        ]);
    }
}
