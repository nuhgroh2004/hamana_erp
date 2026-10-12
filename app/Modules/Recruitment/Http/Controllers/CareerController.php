<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recruitment\Actions\ReceiveApplication;
use App\Modules\Recruitment\Models\JobPosting;
use App\Modules\Recruitment\Models\Source;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index(): View
    {
        $items = JobPosting::where('status', 'active')
            ->where(fn ($q) => $q->whereNull('deadline')->orWhere('deadline', '>=', today()))
            ->with('department')
            ->orderByDesc('published_at')
            ->get();

        return view('recruitment.careers.Careers', ['items' => $items]);
    }

    public function show(JobPosting $jobPosting): View
    {
        abort_unless($jobPosting->status->value === 'active', 404);

        return view('recruitment.careers.CareerShow', [
            'posting' => $jobPosting,
            'sources' => Source::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function apply(Request $request, JobPosting $jobPosting, ReceiveApplication $action): RedirectResponse
    {
        abort_unless($jobPosting->status->value === 'active', 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'national_id' => ['nullable', 'string', 'max:50'],
            'birth_date' => ['nullable', 'date'],
            'city' => ['nullable', 'string', 'max:255'],
            'education' => ['nullable', 'string', 'max:255'],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:50'],
            'source_id' => ['nullable', 'exists:recruitment_sources,id'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'cv' => ['required', 'file', 'max:5120', 'mimes:pdf,jpg,jpeg,png,doc,docx'],
            'ktp' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpg,jpeg,png'],
            'ijazah' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpg,jpeg,png'],
            'sertifikat' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpg,jpeg,png'],
        ], [
            'cv.required' => __('CV wajib diunggah.'),
            'cv.file' => __('CV tidak valid.'),
            'cv.max' => __('Ukuran CV maksimal 5 MB.'),
            'cv.mimes' => __('Format CV harus PDF, gambar, atau DOC.'),
            'required' => __(':attribute wajib diisi.'),
            'email' => __(':attribute tidak valid.'),
            'exists' => __(':attribute tidak valid.'),
            'integer' => __(':attribute harus berupa angka.'),
            'min' => __(':attribute minimal :min.'),
            'max' => __(':attribute maksimal :max.'),
            'date' => __(':attribute tidak valid.'),
            'string' => __(':attribute tidak valid.'),
            'file' => __(':attribute tidak valid.'),
            'mimes' => __('Format file tidak valid.'),
        ], [
            'name' => __('Nama'),
            'phone' => __('No. HP'),
            'national_id' => __('No. KTP'),
            'birth_date' => __('Tanggal Lahir'),
            'city' => __('Kota'),
            'education' => __('Pendidikan'),
            'experience_years' => __('Pengalaman (tahun)'),
            'source_id' => __('Sumber kandidat'),
            'notes' => __('Motivasi'),
            'cv' => 'CV',
            'ktp' => 'KTP',
            'ijazah' => __('Ijazah'),
            'sertifikat' => __('Sertifikat'),
        ]);

        $files = array_filter([
            'cv' => $request->file('cv'),
            'ktp' => $request->file('ktp'),
            'ijazah' => $request->file('ijazah'),
            'sertifikat' => $request->file('sertifikat'),
        ]);

        $action->execute($jobPosting, $data, $files);

        return redirect()
            ->route('recruitment.careers')
            ->with('rc_msg', __('Lamaran Anda telah terkirim. Terima kasih!'));
    }
}
