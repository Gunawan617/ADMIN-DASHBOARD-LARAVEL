<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('video_sections', function (Blueprint $table) {
            // Ubah dari emoji string ke image path
            $table->string('feature1_icon')->nullable()->change();
            $table->string('feature2_icon')->nullable()->change();
            $table->string('feature3_icon')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('video_sections', function (Blueprint $table) {
            $table->string('feature1_icon')->default('📚')->change();
            $table->string('feature2_icon')->default('👨‍🏫')->change();
            $table->string('feature3_icon')->default('✅')->change();
        });
    }
};
