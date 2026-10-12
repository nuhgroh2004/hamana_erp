<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recruitment_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('recruitment_applications')->cascadeOnDelete();
            $table->decimal('base_salary', 15, 2);
            $table->decimal('allowance', 15, 2)->nullable();
            $table->date('start_date');
            $table->date('valid_until');
            $table->string('status')->default('draft');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recruitment_offers');
    }
};
