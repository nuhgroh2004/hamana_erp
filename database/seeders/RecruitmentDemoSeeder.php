<?php

namespace Database\Seeders;

use App\Models\Recruitment\Application;
use App\Models\Recruitment\ApplicationStageLog;
use App\Models\Recruitment\Assessment;
use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\Interview;
use App\Models\Recruitment\JobPosting;
use App\Models\Recruitment\JobRequest;
use App\Models\Recruitment\Offer;
use App\Models\Recruitment\Onboarding;
use App\Models\Recruitment\RejectionReason;
use App\Models\Recruitment\Source;
use App\Models\Recruitment\Stage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RecruitmentDemoSeeder extends Seeder
{
    public function run(): void
    {
        if (JobPosting::withTrashed()->count() > 0) {
            return;
        }

        $stages = Stage::active()->get()->keyBy('order');
        $sources = Source::pluck('id', 'name');
        $now = now();

        $mappings = [
            'Welder 6G (Pengelasan)' => ['dept' => 1, 'lokasi' => 'Pemalang', 'kuota' => 6, 'batas' => '2026-10-30', 'prioritas' => 'tinggi', 'status' => 'active'],
            'Fabricator / Fitter' => ['dept' => 1, 'lokasi' => 'Pemalang', 'kuota' => 8, 'batas' => '2026-11-15', 'prioritas' => 'tinggi', 'status' => 'active'],
            'Operator CNC Plasma' => ['dept' => 1, 'lokasi' => 'Pemalang', 'kuota' => 2, 'batas' => '2026-10-25', 'prioritas' => 'normal', 'status' => 'active'],
            'Painter / Spray' => ['dept' => 1, 'lokasi' => 'Pemalang', 'kuota' => 3, 'batas' => '2026-11-10', 'prioritas' => 'normal', 'status' => 'active'],
            'Engineer Desain (AutoCAD)' => ['dept' => 2, 'lokasi' => 'Pemalang', 'kuota' => 1, 'batas' => '2026-10-20', 'prioritas' => 'tinggi', 'status' => 'active'],
            'QC Inspector (NDT)' => ['dept' => 3, 'lokasi' => 'Pemalang', 'kuota' => 2, 'batas' => '2026-11-05', 'prioritas' => 'normal', 'status' => 'active'],
            'Staf Purchasing' => ['dept' => 5, 'lokasi' => 'Semarang', 'kuota' => 1, 'batas' => '2026-09-30', 'prioritas' => 'normal', 'status' => 'closed'],
            'Teknisi Hidrolik' => ['dept' => 1, 'lokasi' => 'Pemalang', 'kuota' => 2, 'batas' => null, 'prioritas' => 'normal', 'status' => 'draft'],
        ];

        $jobs = [];
        foreach ($mappings as $title => $m) {
            $jobs[$title] = JobPosting::create([
                'title' => $title,
                'department_id' => $m['dept'],
                'location' => $m['lokasi'],
                'quota' => $m['kuota'],
                'deadline' => $m['batas'],
                'priority' => $m['prioritas'],
                'status' => $m['status'],
                'published_at' => $m['status'] === 'active' ? $now->copy()->subDays(10) : null,
                'closed_at' => $m['status'] === 'closed' ? $now->copy()->subDays(5) : null,
            ]);
        }

        $candidates = [
            ['Rizky Pratama', 'Welder 6G (Pengelasan)', 3, 'JobStreet', 5, 'SMK Las', 82, 'Tegal', 'Lulus uji las 6G'],
            ['Dimas Saputra', 'Welder 6G (Pengelasan)', 4, 'Walk-in', 7, 'SMK Las', 88, 'Brebes', 'Sertifikat BNSP'],
            ['Agus Setiawan', 'Welder 6G (Pengelasan)', 1, 'Referral', 3, 'SMK Mesin', 70, 'Pemalang', ''],
            ['Slamet Riyadi', 'Fabricator / Fitter', 2, 'Facebook', 4, 'SMK Mesin', 75, 'Pekalongan', ''],
            ['Fajar Nugroho', 'Fabricator / Fitter', 5, 'Referral', 6, 'D3 Teknik Mesin', 85, 'Batang', 'Interview user 12 Okt'],
            ['Hendra Wijaya', 'Fabricator / Fitter', 6, 'JobStreet', 8, 'SMK Mesin', 90, 'Tegal', 'Offer menunggu jawaban'],
            ['Bayu Kurniawan', 'Operator CNC Plasma', 3, 'Loker.id', 2, 'SMK TPM', 78, 'Pemalang', ''],
            ['Eko Prasetyo', 'Painter / Spray', 0, 'Walk-in', 3, 'SMA', 0, 'Pemalang', ''],
            ['Nanda Putri', 'Engineer Desain (AutoCAD)', 4, 'LinkedIn', 3, 'S1 Teknik Mesin', 86, 'Semarang', 'Portofolio rangka deck'],
            ['Rina Marlina', 'Engineer Desain (AutoCAD)', 3, 'LinkedIn', 2, 'S1 Teknik Industri', 80, 'Semarang', ''],
            ['Yusuf Hidayat', 'QC Inspector (NDT)', 2, 'JobStreet', 5, 'D3 Teknik Material', 0, 'Cirebon', 'Punya sertifikat NDT Lv.2'],
            ['Tono Sugiarto', 'Welder 6G (Pengelasan)', 6, 'Referral', 9, 'SMK Las', 91, 'Pemalang', 'Mulai 1 Nov 2026'],
            ['Wahyu Hidayat', 'Painter / Spray', 1, 'Facebook', 1, 'SMA', 0, 'Tegal', ''],
            ['Lukman Hakim', 'Fabricator / Fitter', 3, 'Walk-in', 2, 'SMK Mesin', 72, 'Pemalang', ''],
            ['Indra Gunawan', 'Operator CNC Plasma', -1, 'Loker.id', 1, 'SMK TPM', 55, 'Brebes', 'Tidak lolos tes teknis'],
        ];

        $sourceMap = [
            'JobStreet' => 'Job Board',
            'Loker.id' => 'Job Board',
            'Walk-in' => 'Walk-in',
            'Referral' => 'Referensi Karyawan',
            'Facebook' => 'Lainnya',
            'LinkedIn' => 'Lainnya',
        ];

        $rejectId = RejectionReason::where('name', 'Gagal tes teknis')->value('id');
        $apps = [];

        foreach ($candidates as $i => [$name, $jobTitle, $st, $src, $exp, $edu, $score, $city, $note]) {
            $email = Str::slug($name, '.') . '@example.com';

            $candidate = Candidate::create([
                'name' => $name,
                'email' => $email,
                'phone' => '0812345' . sprintf('%04d', 100 + $i),
                'city' => $city,
                'education' => $edu,
                'experience_years' => $exp,
                'source_id' => $sources[$sourceMap[$src] ?? 'Lainnya'] ?? null,
                'notes' => $note !== '' ? $note : null,
                'is_talent_pool' => $st < 0,
            ]);

            $appliedAt = $now->copy()->subDays(20 - $i);
            $isHired = $st === 6;
            $isRejected = $st < 0;

            $application = Application::create([
                'candidate_id' => $candidate->id,
                'job_posting_id' => $jobs[$jobTitle]->id,
                'current_stage_id' => $isRejected ? ($stages[3]->id ?? null) : ($stages[min($st, 6) + 1]->id ?? null),
                'status' => $isHired ? 'hired' : ($isRejected ? 'rejected' : 'active'),
                'rejected_reason_id' => $isRejected ? $rejectId : null,
                'active_key' => (string) Str::uuid(),
                'applied_at' => $appliedAt,
                'closed_at' => $isHired ? $now->copy()->subDays(2) : ($isRejected ? $now->copy()->subDays(3) : null),
            ]);

            $apps[$name] = $application;

            if ($score > 0) {
                Assessment::create([
                    'application_id' => $application->id,
                    'type' => 'Tes Teknis',
                    'score' => $score,
                    'passed' => $score >= 75,
                    'assessed_at' => $appliedAt->copy()->addDays(3),
                ]);
            }
        }

        $interviews = [
            ['Rizky Pratama', 'interview_hr', '2026-10-12 09:00', 'Tim HRD', 'Ruang Meeting 1'],
            ['Slamet Riyadi', 'tes_praktik', '2026-10-12 13:30', 'Kepala Produksi', 'Workshop'],
            ['Bayu Kurniawan', 'interview_hr', '2026-10-13 10:00', 'Tim HRD', 'Ruang Meeting 1'],
            ['Nanda Putri', 'interview_user', '2026-10-14 09:00', 'Manajer Dept.', 'Ruang Meeting 1'],
            ['Rina Marlina', 'interview_hr', '2026-10-15 14:00', 'Tim HRD', 'Ruang Meeting 1'],
            ['Yusuf Hidayat', 'tes_praktik', '2026-10-16 09:00', 'Kepala Produksi', 'Workshop'],
            ['Dimas Saputra', 'interview_user', '2026-10-16 13:30', 'Manajer Dept.', 'Ruang Meeting 1'],
            ['Lukman Hakim', 'interview_hr', '2026-10-17 10:00', 'Tim HRD', 'Ruang Meeting 1'],
        ];

        foreach ($interviews as [$name, $type, $when, $interviewer, $place]) {
            Interview::create([
                'application_id' => $apps[$name]->id,
                'type' => $type,
                'scheduled_at' => $when,
                'duration_minutes' => 60,
                'location' => $place,
                'interviewer' => $interviewer,
                'status' => 'scheduled',
            ]);
        }

        $offers = [
            ['Fajar Nugroho', 6325000, 'pending_approval'],
            ['Hendra Wijaya', 6450000, 'accepted'],
            ['Tono Sugiarto', 6475000, 'accepted'],
        ];

        foreach ($offers as [$name, $salary, $status]) {
            Offer::create([
                'application_id' => $apps[$name]->id,
                'base_salary' => $salary,
                'allowance' => 800000,
                'start_date' => '2026-11-01',
                'valid_until' => '2026-10-25',
                'status' => $status,
                'approved_by' => $status === 'accepted' ? 1 : null,
                'responded_at' => $status === 'accepted' ? $now->copy()->subDay() : null,
            ]);
        }

        $templates = \App\Models\Recruitment\OnboardingTemplate::where('is_active', true)->orderBy('order')->pluck('title');
        $onboardings = [
            ['Hendra Wijaya', 5],
            ['Tono Sugiarto', 3],
        ];

        foreach ($onboardings as [$name, $doneCount]) {
            $onboarding = Onboarding::create([
                'application_id' => $apps[$name]->id,
                'start_date' => '2026-11-01',
                'status' => 'ongoing',
            ]);

            foreach ($templates as $i => $title) {
                $onboarding->tasks()->create([
                    'title' => $title,
                    'is_done' => $i < $doneCount,
                    'done_by' => $i < $doneCount ? 1 : null,
                    'done_at' => $i < $doneCount ? $now->copy()->subDays(2) : null,
                ]);
            }
        }

        $logs = [
            ['Rizky Pratama', 4, 3, 2],
            ['Dimas Saputra', 5, 4, 5],
            ['Tono Sugiarto', 7, 6, 26],
            ['Hendra Wijaya', 7, 6, 50],
            ['Nanda Putri', 5, 4, 74],
            ['Fajar Nugroho', 6, 5, 98],
        ];

        foreach ($logs as [$name, $to, $from, $hoursAgo]) {
            ApplicationStageLog::create([
                'application_id' => $apps[$name]->id,
                'from_stage_id' => $stages[$from]->id ?? null,
                'to_stage_id' => $stages[$to]->id ?? null,
                'changed_by' => 1,
                'created_at' => $now->copy()->subHours($hoursAgo),
            ]);
        }

        $positions = [
            ['Teknisi Hidrolik', 1],
            ['Admin Gudang', 6],
        ];
        foreach ($positions as [$pName, $dept]) {
            $exists = \App\Models\Position::where('name', $pName)->exists();
            if (! $exists) {
                \App\Models\Position::create(['name' => $pName, 'department_id' => $dept]);
            }
        }

        $mpps = [
            ['Welder', 1, 4, 'Ekspansi line car carrier', '2026-11-01', 'approved'],
            ['Fabricator', 1, 8, 'Penambahan shift', '2026-11-01', 'approved'],
            ['Teknisi Hidrolik', 1, 2, 'Pengganti resign', '2026-11-15', 'pending'],
            ['Admin Gudang', 6, 1, 'Posisi baru', '2026-12-01', 'rejected'],
        ];

        $nextNo = 1;
        foreach (JobRequest::withTrashed()->pluck('code') as $code) {
            if (preg_match('/(\d+)$/', (string) $code, $m)) {
                $nextNo = max($nextNo, ((int) $m[1]) + 1);
            }
        }

        foreach ($mpps as [$pName, $dept, $qty, $reason, $target, $status]) {
            $position = \App\Models\Position::where('name', $pName)->first();
            if (! $position) {
                continue;
            }

            JobRequest::create([
                'code' => 'MPP-' . sprintf('%04d', $nextNo++),
                'department_id' => $dept,
                'position_id' => $position->id,
                'requested_by' => 1,
                'quantity' => $qty,
                'reason' => $reason,
                'target_date' => $target,
                'status' => $status,
                'approved_by' => $status === 'approved' ? 1 : null,
                'approved_at' => $status === 'approved' ? $now->copy()->subDays(5) : null,
            ]);
        }

        $pool = [
            ['Sari Wulandari', 'sari.wulandari@example.com', 'Semarang', 'S1 Desain Komunikasi Visual', 4, 'Desainer grafis, portofolio kuat', ['Desainer Grafis']],
            ['Joko Susilo', 'joko.susilo@example.com', 'Pemalang', 'SMK Teknik Mesin', 6, 'Teknisi mesin berpengalaman kapal', ['Teknisi Mesin']],
        ];

        foreach ($pool as [$name, $email, $city, $edu, $exp, $note, $tags]) {
            Candidate::create([
                'name' => $name,
                'email' => $email,
                'phone' => '0812999000' . random_int(10, 99),
                'city' => $city,
                'education' => $edu,
                'experience_years' => $exp,
                'source_id' => $sources['Website Perusahaan'] ?? null,
                'notes' => $note,
                'is_talent_pool' => true,
                'talent_tags' => $tags,
            ]);
        }
    }
}
