<?php

namespace App\Modules\Recruitment\Actions;

use App\Modules\Recruitment\Models\JobPosting;
use Illuminate\Validation\ValidationException;

class CloseJobPosting
{
    public function execute(JobPosting $jobPosting): JobPosting
    {
        if ($jobPosting->status->value !== 'active') {
            throw ValidationException::withMessages([
                'job_posting' => __('Hanya lowongan berstatus Aktif yang bisa ditutup.'),
            ]);
        }

        $jobPosting->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return $jobPosting->refresh();
    }
}
