<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Application;
use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\Offer;
use App\Support\RekrutmenData;

class ReportController extends Controller
{
    public function index()
    {
        $rkm = RekrutmenData::all();

        $hiredApps = Application::where('status', 'hired')
            ->whereNotNull('applied_at')
            ->whereNotNull('closed_at')
            ->get();
        $avgDays = $hiredApps->count()
            ? (int) round($hiredApps->avg(fn ($a) => $a->applied_at->diffInDays($a->closed_at)))
            : null;

        $accepted = Offer::where('status', 'accepted')->count();
        $responded = Offer::whereIn('status', ['accepted', 'declined'])->count();
        $acceptance = $responded ? round($accepted / $responded * 100) . '%' : '—';

        $totalApps = Application::count();
        $hiredTotal = Application::where('status', 'hired')->count();
        $ratio = $hiredTotal ? round($totalApps / $hiredTotal, 1) . ' : 1' : '—';

        $ringkasan = [
            [__('Time-to-hire'), $avgDays !== null ? $avgDays . ' ' . __('hari') : '—'],
            [__('Cost-per-hire'), '—'],
            [__('Offer acceptance rate'), $acceptance],
            [__('Rasio pelamar : hired'), $ratio],
        ];

        $candidateTotal = Candidate::count();

        return view('sdm-dan-payroll.rekrutmen.Laporan', compact('rkm', 'ringkasan', 'candidateTotal'));
    }
}
