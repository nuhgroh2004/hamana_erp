<?php

namespace App\Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateDocument extends Model
{
    protected $table = 'recruitment_candidate_documents';

    protected $fillable = ['candidate_id', 'type', 'path', 'original_name', 'size'];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }
}
