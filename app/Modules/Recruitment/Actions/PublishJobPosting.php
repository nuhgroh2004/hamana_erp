<?php

namespace App\Modules\Recruitment\Actions;

use App\Modules\Recruitment\Models\JobPosting;
use Illuminate\Validation\ValidationException;

class PublishJobPosting
{
    public function execute(JobPosting $jobPosting): JobPosting
    {
        if ($jobPosting->status->value !== 'draft') {
            throw ValidationException::withMessages([
                'job_posting' => __('Hanya lowongan berstatus Draft yang bisa dipublikasikan.'),
            ]);
        }

        $jobPosting->update([
            'status' => 'active',
            'published_at' => now(),
            'closed_at' => null,
        ]);

        return $jobPosting->refresh();
    }
}
