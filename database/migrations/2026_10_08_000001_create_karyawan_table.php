<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->string('nik')->primary();
            $table->string('nama');
            $table->string('ktp')->nullable();
            $table->string('tmpLahir')->nullable();
            $table->string('tglLahir')->nullable();
            $table->string('jk')->nullable();
            $table->string('kawin')->nullable();
            $table->string('hp')->nullable();
            $table->string('email')->nullable();
            $table->string('alamat')->nullable();
            $table->string('divisi')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('statusKerja')->nullable();
            $table->json('extra')->nullable();
            $table->json('karier')->nullable();
            $table->json('pendidikan')->nullable();
            $table->json('dokumen')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
