<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recruitment_onboardings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('recruitment_applications')->cascadeOnDelete();
            $table->string('employee_id')->nullable();
            $table->date('start_date');
            $table->string('status')->default('ongoing');
            $table->timestamps();
            $table->foreign('employee_id')->references('nik')->on('karyawan')->nullOnDelete();
        });

        Schema::create('recruitment_onboarding_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('onboarding_id')->constrained('recruitment_onboardings')->cascadeOnDelete();
            $table->string('title');
            $table->boolean('is_done')->default(false);
            $table->foreignId('done_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('done_at')->nullable();
            $table->timestamps();
            $table->index('onboarding_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recruitment_onboarding_tasks');
        Schema::dropIfExists('recruitment_onboardings');
    }
};
