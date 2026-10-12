<?php

namespace App\Modules\Recruitment\Actions;

use App\Models\User;
use App\Modules\Recruitment\Enums\JobRequestStatus;
use App\Modules\Recruitment\Models\JobRequest;
use Illuminate\Support\Facades\DB;

class SubmitJobRequest
{
    public function execute(array $data, ?User $user): JobRequest
    {
        return DB::transaction(function () use ($data, $user) {
            $next = (int) JobRequest::withTrashed()->max('id') + 1;

            return JobRequest::create($data + [
                'code' => 'MPP-'.str_pad((string) $next, 4, '0', STR_PAD_LEFT),
                'requested_by' => $user?->id,
                'status' => JobRequestStatus::Pending->value,
            ]);
        });
    }
}
