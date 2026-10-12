<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recruitment_job_postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_request_id')->nullable()->constrained('recruitment_job_requests')->nullOnDelete();
            $table->string('title');
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('location')->nullable();
            $table->unsignedSmallInteger('quota')->default(1);
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->boolean('requires_certificate')->default(false);
            $table->date('deadline')->nullable();
            $table->string('priority')->default('normal');
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recruitment_job_postings');
    }
};
