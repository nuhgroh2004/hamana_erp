<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Position;
use App\Models\Recruitment\JobRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class JobRequestController extends Controller
{
    public function index()
    {
        $rows = JobRequest::with(['department', 'position'])
            ->latest('id')
            ->get()
            ->map(fn (JobRequest $r) => [
                'id' => $r->id,
                'no' => $r->code,
                'posisi' => $r->position?->name ?? '—',
                'dept' => $r->department?->name ?? '—',
                'jumlah' => (int) $r->quantity,
                'alasan' => $r->reason,
                'statusRaw' => $r->status,
                'status' => match ($r->status) {
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                    'cancelled' => 'Dibatalkan',
                    default => 'Menunggu',
                },
            ])
            ->all();

        $departments = Department::orderBy('name')->get(['id', 'name']);
        $positions = Position::orderBy('name')->get(['id', 'name', 'department_id']);

        return view('sdm-dan-payroll.rekrutmen.PermintaanTenagaKerja', compact('rows', 'departments', 'positions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
            'position_id' => ['required', 'exists:positions,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
            'reason' => ['required', 'string', 'max:1000'],
            'target_date' => ['required', 'date'],
        ]);

        DB::transaction(function () use ($data, $request) {
            $last = JobRequest::withTrashed()->orderByDesc('id')->value('code');
            $next = 1;
            if (preg_match('/(\d+)$/', (string) $last, $m)) {
                $next = ((int) $m[1]) + 1;
            }

            JobRequest::create([
                'code' => sprintf('MPP-%04d', $next),
                'department_id' => $data['department_id'],
                'position_id' => $data['position_id'],
                'requested_by' => $request->user()?->id,
                'quantity' => $data['quantity'],
                'reason' => $data['reason'],
                'target_date' => $data['target_date'],
                'status' => 'pending',
            ]);
        });

        return response()->json(['ok' => true, 'message' => __('Permintaan tenaga kerja dibuat.')]);
    }

    public function updateStatus(Request $request, JobRequest $jobRequest, string $status)
    {
        abort_unless(in_array($status, ['approved', 'rejected', 'cancelled'], true), 422);

        $jobRequest->update([
            'status' => $status,
            'approved_by' => $status === 'approved' ? $request->user()?->id : $jobRequest->approved_by,
            'approved_at' => $status === 'approved' ? now() : $jobRequest->approved_at,
        ]);

        $message = match ($status) {
            'approved' => __('Permintaan disetujui.'),
            'rejected' => __('Permintaan ditolak.'),
            default => __('Permintaan dibatalkan.'),
        };

        return response()->json(['ok' => true, 'message' => $message]);
    }
}
