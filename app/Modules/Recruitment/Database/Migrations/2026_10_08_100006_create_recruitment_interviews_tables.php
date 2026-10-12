<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recruitment_interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('recruitment_applications')->cascadeOnDelete();
            $table->string('type')->default('hr');
            $table->timestamp('scheduled_at');
            $table->unsignedSmallInteger('duration_minutes')->default(60);
            $table->string('location')->nullable();
            $table->string('status')->default('scheduled');
            $table->string('recommendation')->nullable();
            $table->timestamps();
            $table->index('scheduled_at');
        });

        Schema::create('recruitment_interview_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_id')->constrained('recruitment_interviews')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role')->default('interviewer');
            $table->timestamps();
            $table->unique(['interview_id', 'user_id']);
        });

        Schema::create('recruitment_interview_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_id')->constrained('recruitment_interviews')->cascadeOnDelete();
            $table->foreignId('scorer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('criteria');
            $table->decimal('score', 5, 2);
            $table->unsignedTinyInteger('weight')->default(1);
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recruitment_interview_scores');
        Schema::dropIfExists('recruitment_interview_participants');
        Schema::dropIfExists('recruitment_interviews');
    }
};
