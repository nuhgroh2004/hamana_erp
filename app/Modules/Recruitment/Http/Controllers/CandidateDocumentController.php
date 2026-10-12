<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recruitment\Models\Candidate;
use App\Modules\Recruitment\Models\CandidateDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CandidateDocumentController extends Controller
{
    public function store(Request $request, Candidate $candidate): RedirectResponse
    {
        $data = $request->validate([
            'type' => ['required', 'in:cv,ktp,ijazah,sertifikat'],
            'file' => ['required', 'file', 'max:5120', 'mimes:pdf,jpg,jpeg,png,doc,docx'],
        ], [
            'type.required' => __('Jenis dokumen wajib dipilih.'),
            'type.in' => __('Jenis dokumen tidak valid.'),
            'file.required' => __('File wajib dipilih.'),
            'file.file' => __('File tidak valid.'),
            'file.max' => __('Ukuran file maksimal 5 MB.'),
            'file.mimes' => __('Format file harus PDF, gambar, atau DOC.'),
        ]);

        $file = $request->file('file');
        $path = $file->store('recruitment/documents', 'local');

        $existing = CandidateDocument::where('candidate_id', $candidate->id)
            ->where('type', $data['type'])
            ->first();

        if ($existing) {
            Storage::disk('local')->delete($existing->path);
            $existing->update([
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
            ]);
        } else {
            CandidateDocument::create([
                'candidate_id' => $candidate->id,
                'type' => $data['type'],
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
            ]);
        }

        return back()->with('rc_msg', __('Dokumen tersimpan.'));
    }

    public function download(Candidate $candidate, CandidateDocument $document): StreamedResponse
    {
        abort_unless($document->candidate_id === $candidate->id, 404);
        abort_unless(Storage::disk('local')->exists($document->path), 404);

        return Storage::disk('local')->download($document->path, $document->original_name);
    }
}
