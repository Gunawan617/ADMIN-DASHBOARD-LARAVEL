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
        Schema::create('video_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('video_url'); // URL video MP4
            $table->text('video_webm_url')->nullable(); // URL video WEBM (optional)
            $table->text('thumbnail_url'); // URL thumbnail/poster
            $table->string('badge_title')->default('Testimoni Alumni Klinik Ukom');
            $table->string('badge_subtitle')->default('Video otomatis diputar');
            $table->string('feature1_icon')->default('📚');
            $table->string('feature1_title')->default('Materi Lengkap');
            $table->string('feature1_description')->default('Semua materi UKOM dari A-Z');
            $table->string('feature2_icon')->default('👨‍🏫');
            $table->string('feature2_title')->default('Mentor Berpengalaman');
            $table->string('feature2_description')->default('Dibimbing langsung oleh ahli');
            $table->string('feature3_icon')->default('✅');
            $table->string('feature3_title')->default('Garansi Lulus');
            $table->string('feature3_description')->default('Bimbingan hingga lulus UKOM');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_sections');
    }
};
