<?php

namespace App\Modules\Recruitment\Actions;

use App\Models\User;
use App\Modules\Recruitment\Models\Assessment;
use Illuminate\Support\Facades\DB;

class RecordAssessment
{
    public function execute(array $data, ?User $assessor): Assessment
    {
        return DB::transaction(function () use ($data, $assessor) {
            return Assessment::create($data + [
                'assessor_id' => $assessor?->id,
                'assessed_at' => $data['assessed_at'] ?? now(),
            ]);
        });
    }
}
