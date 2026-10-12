<?php

use App\Http\Middleware\ApplyUserLocale;
use App\Modules\Recruitment\Http\Controllers\DashboardController;
use App\Modules\Recruitment\Http\Controllers\JobRequestApprovalController;
use App\Modules\Recruitment\Http\Controllers\JobRequestCancelController;
use App\Modules\Recruitment\Http\Controllers\JobRequestController;
use App\Modules\Recruitment\Http\Controllers\JobPostingController;
use App\Modules\Recruitment\Http\Controllers\JobPostingStatusController;
use App\Modules\Recruitment\Http\Controllers\CandidateController;
use App\Modules\Recruitment\Http\Controllers\CandidateDocumentController;
use App\Modules\Recruitment\Http\Controllers\CareerController;
use App\Modules\Recruitment\Http\Controllers\PipelineController;
use App\Modules\Recruitment\Http\Controllers\InterviewController;
use App\Modules\Recruitment\Http\Controllers\AssessmentController;
use App\Modules\Recruitment\Http\Controllers\OfferController;
use App\Modules\Recruitment\Http\Controllers\OnboardingController;
use App\Modules\Recruitment\Http\Controllers\TalentPoolController;
use App\Modules\Recruitment\Http\Controllers\ReportController;
use App\Modules\Recruitment\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['web', 'auth', ApplyUserLocale::class, LaravelLocalizationRedirectFilter::class, LaravelLocalizationViewPath::class],
], function () {
    Route::get('/recruitment/dashboard', DashboardController::class)->name('recruitment.dashboard');
    Route::get('/recruitment/job-requests', [JobRequestController::class, 'index'])->name('recruitment.job-requests');
    Route::get('/recruitment/job-requests/create', [JobRequestController::class, 'create'])->name('recruitment.job-requests.create');
    Route::post('/recruitment/job-requests', [JobRequestController::class, 'store'])->name('recruitment.job-requests.store');
    Route::get('/recruitment/job-requests/{jobRequest}/edit', [JobRequestController::class, 'edit'])->name('recruitment.job-requests.edit');
    Route::put('/recruitment/job-requests/{jobRequest}', [JobRequestController::class, 'update'])->name('recruitment.job-requests.update');
    Route::post('/recruitment/job-requests/{jobRequest}/approve', JobRequestApprovalController::class)->name('recruitment.job-requests.approve');
    Route::post('/recruitment/job-requests/{jobRequest}/cancel', JobRequestCancelController::class)->name('recruitment.job-requests.cancel');
    Route::get('/recruitment/job-postings', [JobPostingController::class, 'index'])->name('recruitment.job-postings');
    Route::get('/recruitment/job-postings/create', [JobPostingController::class, 'create'])->name('recruitment.job-postings.create');
    Route::post('/recruitment/job-postings', [JobPostingController::class, 'store'])->name('recruitment.job-postings.store');
    Route::get('/recruitment/job-postings/{jobPosting}/edit', [JobPostingController::class, 'edit'])->name('recruitment.job-postings.edit');
    Route::put('/recruitment/job-postings/{jobPosting}', [JobPostingController::class, 'update'])->name('recruitment.job-postings.update');
    Route::post('/recruitment/job-postings/{jobPosting}/publish', [JobPostingStatusController::class, 'publish'])->name('recruitment.job-postings.publish');
    Route::post('/recruitment/job-postings/{jobPosting}/close', [JobPostingStatusController::class, 'close'])->name('recruitment.job-postings.close');
    Route::get('/recruitment/candidates', [CandidateController::class, 'index'])->name('recruitment.candidates');
    Route::get('/recruitment/candidates/create', [CandidateController::class, 'create'])->name('recruitment.candidates.create');
    Route::post('/recruitment/candidates', [CandidateController::class, 'store'])->name('recruitment.candidates.store');
    Route::get('/recruitment/candidates/{candidate}', [CandidateController::class, 'show'])->name('recruitment.candidates.show');
    Route::get('/recruitment/candidates/{candidate}/edit', [CandidateController::class, 'edit'])->name('recruitment.candidates.edit');
    Route::put('/recruitment/candidates/{candidate}', [CandidateController::class, 'update'])->name('recruitment.candidates.update');
    Route::post('/recruitment/candidates/{candidate}/documents', [CandidateDocumentController::class, 'store'])->name('recruitment.candidates.documents.store');
    Route::get('/recruitment/candidates/{candidate}/documents/{document}', [CandidateDocumentController::class, 'download'])->name('recruitment.candidates.documents.download');
    Route::get('/recruitment/pipeline', [PipelineController::class, 'index'])->name('recruitment.pipeline');
    Route::post('/recruitment/pipeline/applications/{application}/move', [PipelineController::class, 'move'])->name('recruitment.pipeline.move');
    Route::post('/recruitment/pipeline/applications/{application}/reject', [PipelineController::class, 'reject'])->name('recruitment.pipeline.reject');
    Route::get('/recruitment/interviews', [InterviewController::class, 'index'])->name('recruitment.interviews');
    Route::post('/recruitment/interviews', [InterviewController::class, 'store'])->name('recruitment.interviews.store');
    Route::post('/recruitment/interviews/{interview}/cancel', [InterviewController::class, 'cancel'])->name('recruitment.interviews.cancel');
    Route::post('/recruitment/assessments', [AssessmentController::class, 'store'])->name('recruitment.assessments.store');
    Route::delete('/recruitment/assessments/{assessment}', [AssessmentController::class, 'destroy'])->name('recruitment.assessments.destroy');
    Route::get('/recruitment/offers', [OfferController::class, 'index'])->name('recruitment.offers');
    Route::post('/recruitment/offers', [OfferController::class, 'store'])->name('recruitment.offers.store');
    Route::post('/recruitment/offers/{offer}/approve', [OfferController::class, 'approve'])->name('recruitment.offers.approve');
    Route::post('/recruitment/offers/{offer}/decline', [OfferController::class, 'decline'])->name('recruitment.offers.decline');
    Route::post('/recruitment/offers/{offer}/accept', [OfferController::class, 'accept'])->name('recruitment.offers.accept');
    Route::get('/recruitment/onboarding', [OnboardingController::class, 'index'])->name('recruitment.onboarding');
    Route::post('/recruitment/onboarding/tasks/{task}/toggle', [OnboardingController::class, 'toggleTask'])->name('recruitment.onboarding.tasks.toggle');
    Route::post('/recruitment/onboarding/{onboarding}/complete', [OnboardingController::class, 'complete'])->name('recruitment.onboarding.complete');
    Route::get('/recruitment/talent-pool', [TalentPoolController::class, 'index'])->name('recruitment.talent-pool');
    Route::post('/recruitment/talent-pool', [TalentPoolController::class, 'add'])->name('recruitment.talent-pool.add');
    Route::post('/recruitment/talent-pool/{candidate}/remove', [TalentPoolController::class, 'remove'])->name('recruitment.talent-pool.remove');
    Route::get('/recruitment/reports', [ReportController::class, 'index'])->name('recruitment.reports');
    Route::get('/recruitment/settings', [SettingController::class, 'index'])->name('recruitment.settings');
    Route::post('/recruitment/settings/stages', [SettingController::class, 'storeStage'])->name('recruitment.settings.stages.store');
    Route::post('/recruitment/settings/stages/{stage}/toggle', [SettingController::class, 'toggleStage'])->name('recruitment.settings.stages.toggle');
    Route::delete('/recruitment/settings/stages/{stage}', [SettingController::class, 'destroyStage'])->name('recruitment.settings.stages.destroy');
    Route::post('/recruitment/settings/reasons', [SettingController::class, 'storeReason'])->name('recruitment.settings.reasons.store');
    Route::post('/recruitment/settings/reasons/{reason}/toggle', [SettingController::class, 'toggleReason'])->name('recruitment.settings.reasons.toggle');
    Route::delete('/recruitment/settings/reasons/{reason}', [SettingController::class, 'destroyReason'])->name('recruitment.settings.reasons.destroy');
    Route::post('/recruitment/settings/sources', [SettingController::class, 'storeSource'])->name('recruitment.settings.sources.store');
    Route::post('/recruitment/settings/sources/{source}/toggle', [SettingController::class, 'toggleSource'])->name('recruitment.settings.sources.toggle');
    Route::delete('/recruitment/settings/sources/{source}', [SettingController::class, 'destroySource'])->name('recruitment.settings.sources.destroy');
    Route::post('/recruitment/settings/onboarding-templates', [SettingController::class, 'storeOnboardingTemplate'])->name('recruitment.settings.onboarding-templates.store');
    Route::post('/recruitment/settings/onboarding-templates/{template}/toggle', [SettingController::class, 'toggleOnboardingTemplate'])->name('recruitment.settings.onboarding-templates.toggle');
});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['web', 'throttle:career', ApplyUserLocale::class, LaravelLocalizationRedirectFilter::class, LaravelLocalizationViewPath::class],
], function () {
    Route::get('/recruitment/careers', [CareerController::class, 'index'])->name('recruitment.careers');
    Route::get('/recruitment/careers/{jobPosting}', [CareerController::class, 'show'])->name('recruitment.careers.show');
    Route::post('/recruitment/careers/{jobPosting}/apply', [CareerController::class, 'apply'])->name('recruitment.careers.apply');
});
