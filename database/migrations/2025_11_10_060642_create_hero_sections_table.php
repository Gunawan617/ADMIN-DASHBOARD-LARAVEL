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
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('badge_text')->default('Dipercaya 5,000+ Peserta');
            $table->string('title');
            $table->text('description');
            $table->string('primary_button_text')->default('Daftar Sekarang');
            $table->string('primary_button_link')->default('/daftar');
            $table->string('secondary_button_text')->default('Video Penjelasan');
            $table->string('secondary_button_link')->nullable();
            $table->text('image_url');
            $table->string('stat1_value')->default('92%');
            $table->string('stat1_label')->default('Tingkat Kelulusan');
            $table->string('stat2_value')->default('100+');
            $table->string('stat2_label')->default('Rumah Sakit Mitra');
            $table->string('stat3_value')->default('4.8/5');
            $table->string('stat3_label')->default('Rating Peserta');
            $table->string('floating_card_text')->default('Peserta Lulus');
            $table->string('floating_card_value')->default('92% Berhasil');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_sections');
    }
};
