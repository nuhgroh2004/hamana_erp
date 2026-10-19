<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recruitment_interviews', function (Blueprint $table) {
            $table->string('interviewer')->nullable()->after('location');
        });
    }

    public function down(): void
    {
        Schema::table('recruitment_interviews', function (Blueprint $table) {
            $table->dropColumn('interviewer');
        });
    }
};
