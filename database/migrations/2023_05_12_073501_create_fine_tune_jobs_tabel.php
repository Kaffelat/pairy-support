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
        Schema::create('fine_tune_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('openai_id')->unique();
            $table->foreignId('ai_model_id')->nullable();
            $table->foreignId('ai_file_id')->nullable();
            $table->foreignId('ai_model_result_file_id')->nullable();
            $table->string('type')->nullable();
            $table->json('events')->nullable();
            $table->integer('epochs')->nullable();
            $table->integer('batch_size')->nullable();
            $table->float('learning_rate_multiplier')->nullable();
            $table->float('prompt_loss_weight')->nullable();
            $table->timestamps();

            $table->foreign('ai_model_id')->references('id')->on('ai_models');
            $table->foreign('ai_file_id')->references('id')->on('ai_files');
            $table->foreign('ai_model_result_file_id')->references('id')->on('ai_model_result_files');
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
