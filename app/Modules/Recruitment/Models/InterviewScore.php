<?php

namespace App\Modules\Recruitment\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterviewScore extends Model
{
    protected $table = 'recruitment_interview_scores';

    protected $fillable = ['interview_id', 'scorer_id', 'criteria', 'score', 'weight', 'comment'];

    protected function casts(): array
    {
        return ['score' => 'float', 'weight' => 'integer'];
    }

    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class);
    }

    public function scorer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'scorer_id');
    }
}
