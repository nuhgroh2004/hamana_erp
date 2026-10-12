<?php

namespace App\Modules\Recruitment\Actions;

use App\Modules\Recruitment\Models\Candidate;
use Illuminate\Support\Facades\DB;

class MoveToTalentPool
{
    public function execute(Candidate $candidate, bool $inPool, array $tags = []): Candidate
    {
        return DB::transaction(function () use ($candidate, $inPool, $tags) {
            $candidate->update([
                'is_talent_pool' => $inPool,
                'talent_tags' => $inPool ? array_values(array_filter($tags)) : [],
            ]);

            return $candidate;
        });
    }
}
