<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recruitment\Models\EmailTemplate;
use App\Modules\Recruitment\Models\OnboardingTemplate;
use App\Modules\Recruitment\Models\RejectionReason;
use App\Modules\Recruitment\Models\Source;
use App\Modules\Recruitment\Models\Stage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(): View
    {
        return view('recruitment.settings.Settings', [
            'stages' => Stage::orderBy('order')->get(),
            'reasons' => RejectionReason::orderBy('name')->get(),
            'sources' => Source::orderBy('name')->get(),
            'emailTemplates' => EmailTemplate::orderBy('key')->get(),
            'onboardingTemplates' => OnboardingTemplate::orderBy('order')->get(),
        ]);
    }

    public function storeStage(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:recruitment_stages,name'],
        ], [
            'name.required' => __('Nama tahap wajib diisi.'),
            'name.unique' => __('Nama tahap sudah ada.'),
            'name.max' => __('Nama tahap maksimal :max karakter.'),
        ]);

        $maxOrder = (int) Stage::max('order');
        Stage::create($data + ['order' => $maxOrder + 1, 'is_active' => true, 'is_final' => false]);

        return back()->with('rc_msg', __('Tahap ditambahkan.'));
    }

    public function toggleStage(Stage $stage): RedirectResponse
    {
        $stage->update(['is_active' => !$stage->is_active]);

        return back()->with('rc_msg', __('Tahap diperbarui.'));
    }

    public function destroyStage(Stage $stage): RedirectResponse
    {
        if ($stage->applications()->exists()) {
            return back()->with('rc_errors', __('Tahap memiliki lamaran dan tidak dapat dihapus.'));
        }

        $stage->delete();

        return back()->with('rc_msg', __('Tahap dihapus.'));
    }

    public function storeReason(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:recruitment_rejection_reasons,name'],
        ], [
            'name.required' => __('Nama alasan wajib diisi.'),
            'name.unique' => __('Nama alasan sudah ada.'),
            'name.max' => __('Nama alasan maksimal :max karakter.'),
        ]);

        RejectionReason::create($data + ['is_active' => true]);

        return back()->with('rc_msg', __('Alasan ditambahkan.'));
    }

    public function toggleReason(RejectionReason $reason): RedirectResponse
    {
        $reason->update(['is_active' => !$reason->is_active]);

        return back()->with('rc_msg', __('Alasan diperbarui.'));
    }

    public function destroyReason(RejectionReason $reason): RedirectResponse
    {
        if ($reason->applications()->exists()) {
            return back()->with('rc_errors', __('Alasan digunakan lamaran dan tidak dapat dihapus.'));
        }

        $reason->delete();

        return back()->with('rc_msg', __('Alasan dihapus.'));
    }

    public function storeSource(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:recruitment_sources,name'],
        ], [
            'name.required' => __('Nama sumber wajib diisi.'),
            'name.unique' => __('Nama sumber sudah ada.'),
            'name.max' => __('Nama sumber maksimal :max karakter.'),
        ]);

        Source::create($data + ['is_active' => true]);

        return back()->with('rc_msg', __('Sumber ditambahkan.'));
    }

    public function toggleSource(Source $source): RedirectResponse
    {
        $source->update(['is_active' => !$source->is_active]);

        return back()->with('rc_msg', __('Sumber diperbarui.'));
    }

    public function destroySource(Source $source): RedirectResponse
    {
        if ($source->candidates()->exists()) {
            return back()->with('rc_errors', __('Sumber digunakan kandidat dan tidak dapat dihapus.'));
        }

        $source->delete();

        return back()->with('rc_msg', __('Sumber dihapus.'));
    }

    public function storeOnboardingTemplate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ], [
            'title.required' => __('Judul tugas wajib diisi.'),
            'title.max' => __('Judul tugas maksimal :max karakter.'),
        ]);

        $maxOrder = (int) OnboardingTemplate::max('order');
        OnboardingTemplate::create($data + ['order' => $maxOrder + 1, 'is_active' => true]);

        return back()->with('rc_msg', __('Tugas onboarding ditambahkan.'));
    }

    public function toggleOnboardingTemplate(OnboardingTemplate $template): RedirectResponse
    {
        $template->update(['is_active' => !$template->is_active]);

        return back()->with('rc_msg', __('Tugas onboarding diperbarui.'));
    }
}
