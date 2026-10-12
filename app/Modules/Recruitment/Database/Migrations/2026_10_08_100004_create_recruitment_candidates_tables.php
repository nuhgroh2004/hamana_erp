<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recruitment_candidates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->index();
            $table->string('phone')->nullable();
            $table->string('national_id')->nullable()->index();
            $table->date('birth_date')->nullable();
            $table->string('city')->nullable();
            $table->string('education')->nullable();
            $table->unsignedTinyInteger('experience_years')->default(0);
            $table->foreignId('source_id')->nullable()->constrained('recruitment_sources')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_talent_pool')->default(false);
            $table->json('talent_tags')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('recruitment_candidate_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('recruitment_candidates')->cascadeOnDelete();
            $table->string('type');
            $table->string('path');
            $table->string('original_name');
            $table->unsignedBigInteger('size')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recruitment_candidate_documents');
        Schema::dropIfExists('recruitment_candidates');
    }
};
