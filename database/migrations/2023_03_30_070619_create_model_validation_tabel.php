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
        Schema::create('model_validations', function (Blueprint $table) {
            $table->id();
            $table->integer('ai_model_id');
            $table->integer('model_data_id');
            $table->integer('traning_loss');
            $table->integer('traning_sequence_accuracy');
            $table->integer('traning_token_accuracy');
            $table->integer('elapsed_tokens');
            $table->integer('elapsed_examples');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
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
