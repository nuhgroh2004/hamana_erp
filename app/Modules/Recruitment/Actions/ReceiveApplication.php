<?php

namespace App\Modules\Recruitment\Actions;

use App\Modules\Recruitment\Models\Application;
use App\Modules\Recruitment\Models\ApplicationStageLog;
use App\Modules\Recruitment\Models\Candidate;
use App\Modules\Recruitment\Models\CandidateDocument;
use App\Modules\Recruitment\Models\JobPosting;
use App\Modules\Recruitment\Models\Stage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ReceiveApplication
{
    public function execute(JobPosting $posting, array $data, array $files = []): Application
    {
        return DB::transaction(function () use ($posting, $data, $files) {
            $candidate = Candidate::firstOrNew(['email' => $data['email']]);
            $candidate->fill(array_filter([
                'name' => $data['name'] ?? null,
                'phone' => $data['phone'] ?? null,
                'national_id' => $data['national_id'] ?? null,
                'birth_date' => $data['birth_date'] ?? null,
                'city' => $data['city'] ?? null,
                'education' => $data['education'] ?? null,
                'experience_years' => $data['experience_years'] ?? null,
                'source_id' => $data['source_id'] ?? null,
                'notes' => $data['notes'] ?? null,
            ], fn ($v) => $v !== null && $v !== ''));
            $candidate->save();

            $activeKey = $candidate->id.':'.$posting->id;
            $exists = Application::where('active_key', $activeKey)->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'email' => __('Anda sudah mengirim lamaran untuk posisi ini.'),
                ]);
            }

            $firstStage = Stage::active()->firstOrFail();

            $application = Application::create([
                'candidate_id' => $candidate->id,
                'job_posting_id' => $posting->id,
                'current_stage_id' => $firstStage->id,
                'status' => 'active',
                'active_key' => $activeKey,
                'applied_at' => now(),
            ]);

            ApplicationStageLog::create([
                'application_id' => $application->id,
                'from_stage_id' => null,
                'to_stage_id' => $firstStage->id,
                'changed_by' => null,
                'reason' => __('Lamaran masuk via halaman karier.'),
            ]);

            foreach ($files as $type => $file) {
                if (!$file instanceof \Illuminate\Http\UploadedFile) {
                    continue;
                }

                CandidateDocument::create([
                    'candidate_id' => $candidate->id,
                    'type' => $type,
                    'path' => $file->store('recruitment/documents', 'local'),
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                ]);
            }

            return $application;
        });
    }
}
