<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recruitment\Actions\RecordAssessment;
use App\Modules\Recruitment\Models\Assessment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssessmentController extends Controller
{
    public function store(Request $request, RecordAssessment $action): RedirectResponse
    {
        $data = $request->validate([
            'application_id' => ['required', 'exists:recruitment_applications,id'],
            'type' => ['required', 'string', 'max:255'],
            'score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'passed' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'attachment' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpg,jpeg,png,doc,docx'],
        ], [
            'application_id.required' => __('Lamaran wajib dipilih.'),
            'application_id.exists' => __('Lamaran tidak valid.'),
            'type.required' => __('Jenis tes wajib diisi.'),
            'type.max' => __('Jenis tes maksimal :max karakter.'),
            'score.numeric' => __('Skor harus berupa angka.'),
            'score.min' => __('Skor minimal :min.'),
            'score.max' => __('Skor maksimal :max.'),
            'notes.max' => __('Catatan maksimal :max karakter.'),
            'attachment.file' => __('Lampiran tidak valid.'),
            'attachment.max' => __('Ukuran lampiran maksimal 5 MB.'),
            'attachment.mimes' => __('Format lampiran harus PDF, gambar, atau DOC.'),
        ], [
            'application_id' => __('Lamaran'),
            'type' => __('Jenis tes'),
            'score' => __('Skor'),
            'notes' => __('Catatan'),
            'attachment' => __('Lampiran'),
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('recruitment/assessments', 'local');
        }

        $action->execute([
            'application_id' => $data['application_id'],
            'type' => $data['type'],
            'score' => $data['score'] ?? null,
            'passed' => $request->boolean('passed'),
            'notes' => $data['notes'] ?? null,
            'attachment_path' => $path,
        ], $request->user());

        return back()->with('rc_msg', __('Hasil tes tersimpan.'));
    }

    public function destroy(Assessment $assessment): RedirectResponse
    {
        if ($assessment->attachment_path) {
            Storage::disk('local')->delete($assessment->attachment_path);
        }

        $assessment->delete();

        return back()->with('rc_msg', __('Hasil tes dihapus.'));
    }
}
