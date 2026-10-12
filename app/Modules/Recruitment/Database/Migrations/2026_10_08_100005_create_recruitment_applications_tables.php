<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recruitment_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('recruitment_candidates')->cascadeOnDelete();
            $table->foreignId('job_posting_id')->constrained('recruitment_job_postings')->cascadeOnDelete();
            $table->foreignId('current_stage_id')->nullable()->constrained('recruitment_stages')->nullOnDelete();
            $table->string('status')->default('active');
            $table->foreignId('rejected_reason_id')->nullable()->constrained('recruitment_rejection_reasons')->nullOnDelete();
            $table->string('active_key')->nullable()->unique();
            $table->timestamp('applied_at');
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['job_posting_id', 'current_stage_id']);
            $table->index(['candidate_id', 'job_posting_id']);
        });

        Schema::create('recruitment_application_stage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('recruitment_applications')->cascadeOnDelete();
            $table->foreignId('from_stage_id')->nullable()->constrained('recruitment_stages')->nullOnDelete();
            $table->foreignId('to_stage_id')->nullable()->constrained('recruitment_stages')->nullOnDelete();
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('reason')->nullable();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('recruitment_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('recruitment_applications')->cascadeOnDelete();
            $table->string('type');
            $table->decimal('score', 5, 2)->nullable();
            $table->boolean('passed')->default(false);
            $table->foreignId('assessor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->string('attachment_path')->nullable();
            $table->timestamp('assessed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recruitment_assessments');
        Schema::dropIfExists('recruitment_application_stage_logs');
        Schema::dropIfExists('recruitment_applications');
    }
};
