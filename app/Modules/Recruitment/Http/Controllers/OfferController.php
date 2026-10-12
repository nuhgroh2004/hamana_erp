<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recruitment\Actions\AcceptOffer;
use App\Modules\Recruitment\Actions\ApproveOffer;
use App\Modules\Recruitment\Actions\CreateOffer;
use App\Modules\Recruitment\Enums\OfferStatus;
use App\Modules\Recruitment\Models\Application;
use App\Modules\Recruitment\Models\Offer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index(): View
    {
        $items = Offer::with(['application.candidate', 'application.jobPosting', 'approver'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('recruitment.offers.Offers', [
            'items' => $items,
            'applications' => Application::where('status', 'active')
                ->with(['candidate', 'jobPosting'])
                ->get(),
            'statuses' => OfferStatus::cases(),
        ]);
    }

    public function store(Request $request, CreateOffer $action): RedirectResponse
    {
        $data = $request->validate([
            'application_id' => ['required', 'exists:recruitment_applications,id'],
            'base_salary' => ['required', 'numeric', 'min:0', 'max:999999999999999'],
            'allowance' => ['nullable', 'numeric', 'min:0', 'max:999999999999999'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'valid_until' => ['required', 'date', 'after_or_equal:start_date'],
        ], [
            'application_id.required' => __('Lamaran wajib dipilih.'),
            'application_id.exists' => __('Lamaran tidak valid.'),
            'base_salary.required' => __('Gaji pokok wajib diisi.'),
            'base_salary.numeric' => __('Gaji pokok harus berupa angka.'),
            'base_salary.min' => __('Gaji pokok minimal :min.'),
            'base_salary.max' => __('Gaji pokok tidak valid.'),
            'allowance.numeric' => __('Tunjangan harus berupa angka.'),
            'allowance.min' => __('Tunjangan minimal :min.'),
            'allowance.max' => __('Tunjangan tidak valid.'),
            'start_date.required' => __('Tanggal mulai wajib diisi.'),
            'start_date.date' => __('Tanggal mulai tidak valid.'),
            'start_date.after_or_equal' => __('Tanggal mulai tidak boleh lampau.'),
            'valid_until.required' => __('Masa berlaku wajib diisi.'),
            'valid_until.date' => __('Masa berlaku tidak valid.'),
            'valid_until.after_or_equal' => __('Masa berlaku harus setelah tanggal mulai.'),
        ], [
            'application_id' => __('Lamaran'),
            'base_salary' => __('Gaji pokok'),
            'allowance' => __('Tunjangan'),
            'start_date' => __('Tanggal mulai'),
            'valid_until' => __('Masa berlaku'),
        ]);

        $action->execute(Application::findOrFail($data['application_id']), $data);

        return back()->with('rc_msg', __('Penawaran dibuat dan menunggu persetujuan.'));
    }

    public function approve(Offer $offer, ApproveOffer $action): RedirectResponse
    {
        $action->execute($offer, request()->user());

        return back()->with('rc_msg', __('Penawaran disetujui.'));
    }

    public function decline(Offer $offer): RedirectResponse
    {
        abort_unless(in_array($offer->status->value, ['draft', 'pending_approval', 'approved', 'sent'], true), 422);

        $offer->update([
            'status' => 'declined',
            'responded_at' => now(),
        ]);

        return back()->with('rc_msg', __('Penawaran ditolak.'));
    }

    public function accept(Offer $offer, AcceptOffer $action): RedirectResponse
    {
        $action->execute($offer);

        return back()->with('rc_msg', __('Penawaran diterima. Onboarding dan draft karyawan dibuat.'));
    }
}
