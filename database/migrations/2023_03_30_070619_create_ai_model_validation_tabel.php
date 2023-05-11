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
        Schema::create('ai_model_validations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_model_id');
            $table->foreignId('ai_file_id');
            $table->string('openai_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('ai_model_id')->references('id')->on('ai_models');
            $table->foreign('ai_file_id')->references('id')->on('ai_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_traning_tabel');
    }
};
