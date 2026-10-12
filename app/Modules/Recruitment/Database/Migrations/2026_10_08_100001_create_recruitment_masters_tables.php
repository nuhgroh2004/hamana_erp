<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recruitment_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('recruitment_rejection_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('recruitment_stages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('order');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_final')->default(false);
            $table->timestamps();
        });

        Schema::create('recruitment_email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('subject');
            $table->text('body');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('recruitment_onboarding_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedTinyInteger('order');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recruitment_onboarding_templates');
        Schema::dropIfExists('recruitment_email_templates');
        Schema::dropIfExists('recruitment_stages');
        Schema::dropIfExists('recruitment_rejection_reasons');
        Schema::dropIfExists('recruitment_sources');
    }
};
