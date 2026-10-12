<?php

namespace App\Modules\Recruitment\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterviewParticipant extends Model
{
    protected $table = 'recruitment_interview_participants';

    protected $fillable = ['interview_id', 'user_id', 'role'];

    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
