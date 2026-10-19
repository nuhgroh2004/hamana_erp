<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recruitment_forms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(false);
            $table->text('success_msg')->nullable();
            $table->unsignedInteger('response_limit')->default(0);
            $table->date('close_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('recruitment_form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('recruitment_forms')->cascadeOnDelete();
            $table->string('type');
            $table->string('label');
            $table->text('help')->nullable();
            $table->json('options')->nullable();
            $table->json('file_types')->nullable();
            $table->unsignedTinyInteger('max_mb')->default(5);
            $table->boolean('is_required')->default(false);
            $table->unsignedSmallInteger('ord')->default(0);
            $table->timestamps();
            $table->index('form_id');
        });

        Schema::create('recruitment_form_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('recruitment_forms')->cascadeOnDelete();
            $table->timestamp('submitted_at');
            $table->json('values')->nullable();
            $table->json('files')->nullable();
            $table->timestamps();
            $table->index('form_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recruitment_form_responses');
        Schema::dropIfExists('recruitment_form_fields');
        Schema::dropIfExists('recruitment_forms');
    }
};
