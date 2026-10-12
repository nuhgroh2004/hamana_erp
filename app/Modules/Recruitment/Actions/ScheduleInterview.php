<?php

namespace App\Modules\Recruitment\Actions;

use App\Models\User;
use App\Modules\Recruitment\Models\Interview;
use App\Modules\Recruitment\Models\InterviewParticipant;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ScheduleInterview
{
    public function execute(Interview $template, ?User $actor = null): Interview
    {
        return DB::transaction(function () use ($template, $actor) {
            $start = $template->scheduled_at;
            $end = $start->copy()->addMinutes($template->duration_minutes);

            $conflict = Interview::where('location', $template->location)
                ->where('location', '!=', '')
                ->where('id', '!=', $template->id)
                ->where('status', '!=', 'cancelled')
                ->where('scheduled_at', '<', $end)
                ->where(fn ($q) => $q->whereRaw('DATE_ADD(scheduled_at, INTERVAL duration_minutes MINUTE) > ?', [$start]))
                ->first();

            if ($conflict) {
                throw ValidationException::withMessages([
                    'scheduled_at' => __('Jadwal bentrok dengan interview lain pada ruangan tersebut.'),
                ]);
            }

            $userIds = $template->participants->pluck('user_id')->all();
            if ($userIds) {
                $interviewerConflict = Interview::whereIn('id', function ($q) use ($userIds) {
                    $q->select('interview_id')->from('recruitment_interview_participants')
                        ->whereIn('user_id', $userIds);
                })
                    ->where('id', '!=', $template->id)
                    ->where('status', '!=', 'cancelled')
                    ->where('scheduled_at', '<', $end)
                    ->where(fn ($q) => $q->whereRaw('DATE_ADD(scheduled_at, INTERVAL duration_minutes MINUTE) > ?', [$start]))
                    ->exists();

                if ($interviewerConflict) {
                    throw ValidationException::withMessages([
                        'scheduled_at' => __('Jadwal bentrok dengan jadwal pewawancara.'),
                    ]);
                }
            }

            $template->update(['status' => 'scheduled']);

            return $template;
        });
    }

    public function attachParticipants(Interview $interview, array $userIds): void
    {
        foreach (array_unique($userIds) as $userId) {
            InterviewParticipant::firstOrCreate([
                'interview_id' => $interview->id,
                'user_id' => $userId,
            ], ['role' => 'interviewer']);
        }
    }
}
