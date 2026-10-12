<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recruitment\Actions\CloseJobPosting;
use App\Modules\Recruitment\Actions\PublishJobPosting;
use App\Modules\Recruitment\Models\JobPosting;
use Illuminate\Http\RedirectResponse;

class JobPostingStatusController extends Controller
{
    public function publish(JobPosting $jobPosting, PublishJobPosting $action): RedirectResponse
    {
        $action->execute($jobPosting);

        return back()->with('rc_msg', __('Lowongan :title dipublikasikan.', ['title' => $jobPosting->title]));
    }

    public function close(JobPosting $jobPosting, CloseJobPosting $action): RedirectResponse
    {
        $action->execute($jobPosting);

        return back()->with('rc_msg', __('Lowongan :title ditutup.', ['title' => $jobPosting->title]));
    }
}
