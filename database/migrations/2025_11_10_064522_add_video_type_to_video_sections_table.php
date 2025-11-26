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
        Schema::table('video_sections', function (Blueprint $table) {
            $table->enum('video_type', ['upload', 'youtube'])->default('upload')->after('description');
            $table->string('youtube_url')->nullable()->after('video_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('video_sections', function (Blueprint $table) {
            $table->dropColumn(['video_type', 'youtube_url']);
        });
    }
};
