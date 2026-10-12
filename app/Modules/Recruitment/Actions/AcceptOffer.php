<?php

namespace App\Modules\Recruitment\Actions;

use App\Models\Karyawan;
use App\Modules\Recruitment\Models\Application;
use App\Modules\Recruitment\Models\ApplicationStageLog;
use App\Modules\Recruitment\Models\Offer;
use App\Modules\Recruitment\Models\Onboarding;
use App\Modules\Recruitment\Models\OnboardingTemplate;
use App\Modules\Recruitment\Models\Stage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AcceptOffer
{
    public function execute(Offer $offer): Application
    {
        return DB::transaction(function () use ($offer) {
            if (!in_array($offer->status->value, ['approved', 'sent'], true)) {
                throw ValidationException::withMessages([
                    'status' => __('Penawaran harus disetujui sebelum diterima.'),
                ]);
            }

            if ($offer->valid_until->isPast()) {
                throw ValidationException::withMessages([
                    'status' => __('Masa berlaku penawaran sudah habis.'),
                ]);
            }

            $offer->update([
                'status' => 'accepted',
                'responded_at' => now(),
            ]);

            $application = $offer->application()->with(['candidate', 'jobPosting.department'])->firstOrFail();
            $candidate = $application->candidate;

            $application->update([
                'status' => 'hired',
                'closed_at' => now(),
                'active_key' => null,
            ]);

            $hiredStage = Stage::where('is_final', true)->first();
            $previousStage = $application->current_stage_id;

            if ($hiredStage) {
                $application->update(['current_stage_id' => $hiredStage->id]);

                ApplicationStageLog::create([
                    'application_id' => $application->id,
                    'from_stage_id' => $previousStage,
                    'to_stage_id' => $hiredStage->id,
                    'changed_by' => null,
                    'reason' => __('Penawaran diterima.'),
                ]);
            }

            $employee = $this->createDraftKaryawan($candidate, $application, $offer);

            $onboarding = Onboarding::create([
                'application_id' => $application->id,
                'employee_id' => $employee->nik,
                'start_date' => $offer->start_date,
                'status' => 'ongoing',
            ]);

            $templates = OnboardingTemplate::where('is_active', true)->orderBy('order')->get();
            foreach ($templates as $t) {
                $onboarding->tasks()->create(['title' => $t->title]);
            }

            return $application;
        });
    }

    private function createDraftKaryawan($candidate, Application $application, Offer $offer): Karyawan
    {
        $max = Karyawan::pluck('nik')
            ->map(fn ($n) => (int) preg_replace('/\D+/', '', $n))
            ->max() ?? 0;

        $nik = 'HW-'.str_pad((string) ($max + 1), 5, '0', STR_PAD_LEFT);

        return Karyawan::create([
            'nik' => $nik,
            'nama' => $candidate->name,
            'ktp' => $candidate->national_id,
            'tglLahir' => $candidate->birth_date?->format('Y-m-d'),
            'hp' => $candidate->phone,
            'email' => $candidate->email,
            'divisi' => $application->jobPosting->department?->name ?? '-',
            'jabatan' => $application->jobPosting->title,
            'statusKerja' => 'Kontrak',
            'pendidikan' => ['ijasan' => $candidate->education],
            'extra' => [
                'gajiPokok' => (float) $offer->base_salary,
                'tunjangan' => (float) ($offer->allowance ?? 0),
                'sumberRekrutmen' => 'Modul Rekrutmen',
            ],
        ]);
    }
}
