<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ai_file_fine_tune_job_pivot', function (Blueprint $table) {
            $table->foreignId('ai_file_id')->nullable();
            $table->foreignId('fine_tune_job_id')->nullable();
            $table->timestamps();

            $table->foreign('ai_file_id')->references('id')->on('ai_files');
            $table->foreign('fine_tune_job_id')->references('id')->on('fine_tune_jobs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fine_tune_jobs_tabel');
    }
};
