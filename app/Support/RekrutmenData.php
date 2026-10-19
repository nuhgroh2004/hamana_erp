<?php

namespace App\Support;

use App\Models\Recruitment\Application;
use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\JobPosting;
use App\Models\Recruitment\Stage;
use Illuminate\Support\Collection;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RekrutmenData
{
    public const STAGE_NAMES = ['Baru', 'Screening', 'Tes Teknis', 'Interview HR', 'Interview User', 'Offering', 'Hired'];

    private const MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    private const DAYS = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

    private static ?Collection $stageCache = null;

    public static function stageRows(): Collection
    {
        return self::$stageCache ??= Stage::active()->get();
    }

    public static function stages(): array
    {
        $names = [];
        foreach (self::stageRows() as $s) {
            $names[$s->order - 1] = $s->name;
        }

        return $names ?: self::STAGE_NAMES;
    }

    public static function firstStageId(): ?int
    {
        return self::stageRows()->first()?->id;
    }

    public static function stageIdByIndex(int $index): ?int
    {
        return self::stageRows()->firstWhere('order', $index + 1)?->id;
    }

    public static function hiredStageId(): ?int
    {
        return self::stageRows()->firstWhere('is_final', true)?->id
            ?? self::stageRows()->last()?->id;
    }

    public static function jobs(): array
    {
        return JobPosting::with('department')
            ->withCount('applications')
            ->withCount(['applications as hired_count' => fn ($q) => $q->where('status', 'hired')])
            ->orderByDesc('id')
            ->get()
            ->map(fn (JobPosting $j) => [
                'id' => $j->id,
                'posisi' => $j->title,
                'dept' => $j->department?->name ?? '—',
                'lokasi' => $j->location ?? '—',
                'kuota' => (int) $j->quota,
                'pelamar' => (int) $j->applications_count,
                'hired' => (int) $j->hired_count,
                'status' => match ($j->status) {
                    'active' => 'Aktif',
                    'closed' => 'Ditutup',
                    default => 'Draft',
                },
                'batas' => $j->deadline ? self::tgl($j->deadline) : '—',
                'prioritas' => $j->priority === 'tinggi' ? 'Tinggi' : 'Normal',
                'statusRaw' => $j->status,
            ])
            ->all();
    }

    public static function applications($query): array
    {
        return $query
            ->with(['candidate.source', 'jobPosting', 'currentStage'])
            ->withMax('assessments', 'score')
            ->get()
            ->map(fn (Application $a) => self::mapApplication($a))
            ->all();
    }

    public static function baseApplicationsQuery()
    {
        return Application::query();
    }

    public static function mapApplication(Application $a): array
    {
        $rejected = $a->status === 'rejected';
        $stageIndex = $rejected ? -1 : max(0, (int) ($a->currentStage?->order ?? 1) - 1);
        $stages = self::stageRows();
        $next = $stages->firstWhere('order', $stageIndex + 2);

        return [
            'app' => $a->id,
            'cid' => $a->candidate_id,
            'n' => $a->candidate?->name ?? '—',
            'job' => $a->jobPosting?->title ?? '—',
            'st' => $stageIndex,
            'src' => $a->candidate?->source?->name ?? '—',
            'exp' => (int) ($a->candidate?->experience_years ?? 0),
            'edu' => $a->candidate?->education ?? '—',
            'sc' => (int) ($a->assessments_max_score ?? 0),
            'city' => $a->candidate?->city ?? '—',
            'note' => $a->candidate?->notes ?? '',
            'status' => $a->status,
            'moveUrl' => ($a->status !== 'hired' && $next && $stageIndex >= 0)
                ? route('rekrutmen.pipeline.move', ['application' => $a->id, 'stage' => $next->id])
                : null,
            'moveNext' => ($a->status !== 'hired' && $next && $stageIndex >= 0) ? $next->name : null,
            'rejectUrl' => $a->status === 'active' ? route('rekrutmen.pipeline.reject', $a->id) : null,
            'reactivateUrl' => $a->status === 'rejected' ? route('rekrutmen.pipeline.reactivate', $a->id) : null,
            'schedUrl' => LaravelLocalization::localizeURL('sdm-dan-payroll/rekrutmen/jadwal-interview'),
        ];
    }

    public static function stageTag(int $st): string
    {
        if ($st < 0) {
            return '<span class="rkm-tag r">' . __('Ditolak') . '</span>';
        }

        $cls = match (true) {
            $st >= 6 => 'g',
            $st >= 5 => 'y',
            $st >= 3 => 'b',
            default => 'n',
        };

        return '<span class="rkm-tag ' . $cls . '">' . __(self::stages()[$st] ?? 'Baru') . '</span>';
    }

    public static function jobTag(string $status): string
    {
        $cls = match ($status) {
            'Aktif' => 'g',
            'Draft' => 'y',
            default => 'r',
        };

        return '<span class="rkm-tag ' . $cls . '">' . __($status) . '</span>';
    }

    public static function tgl($date): string
    {
        if (! $date) {
            return '—';
        }

        $d = \Illuminate\Support\Carbon::parse($date);

        return $d->day . ' ' . self::MONTHS[$d->month - 1] . ' ' . $d->year;
    }

    public static function waktu($dt): string
    {
        if (! $dt) {
            return '—';
        }

        $d = \Illuminate\Support\Carbon::parse($dt);

        return self::DAYS[$d->dayOfWeekIso - 1] . ', ' . $d->day . ' ' . self::MONTHS[$d->month - 1] . ' · ' . $d->format('H:i');
    }

    public static function all(): array
    {
        return [
            'stages' => self::stages(),
            'jobs' => self::jobs(),
            'candidates' => self::applications(Application::query()),
            'rkmStageTag' => fn (int $st) => self::stageTag($st),
            'rkmJobTag' => fn (string $status) => self::jobTag($status),
        ];
    }
}
