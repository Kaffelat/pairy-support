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
        Schema::table('ai_files', function (Blueprint $table) {
            $table->string('name')->after('user_id')->nullable();
            $table->string('file_purpose')->after('name')->nullable();
            $table->integer('byte_size')->after('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_files', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('file_purpose');
            $table->dropColumn('byte_size');
        });
    }
};
