<?php

namespace App\Modules\Recruitment\Actions;

use App\Modules\Recruitment\Models\JobPosting;

class AutoCloseJobPostings
{
    public function execute(): int
    {
        $closed = 0;

        JobPosting::where('status', 'active')->chunkById(50, function ($postings) use (&$closed) {
            foreach ($postings as $jobPosting) {
                $expired = $jobPosting->deadline !== null && $jobPosting->deadline->isPast();
                $full = $jobPosting->hiredCount() >= $jobPosting->quota;

                if ($expired || $full) {
                    $jobPosting->update(['status' => 'closed', 'closed_at' => now()]);
                    $closed++;
                }
            }
        });

        return $closed;
    }
}
