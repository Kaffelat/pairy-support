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
        Schema::create('ai_modeles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('model_data_id');
            $table->string('openai_id')->uniqid();
            $table->string('type');
            $table->integer('epochs');
            $table->integer('max_tokens');
            $table->integer('temparture');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('model_data_id')->references('id')->on('model_data');
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
