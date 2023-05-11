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
        Schema::create('ai_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('openai_id')->unique();
            $table->string('type')->nullable();
            $table->foreignId('ai_file_id')->nullable();
            $table->integer('epochs')->nullable();
            $table->integer('batch_size')->nullable();
            $table->float('learning_rate_multiplier')->nullable();
            $table->float('prompt_loss_weight')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('ai_file_id')->references('id')->on('ai_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_model');
    }
};
