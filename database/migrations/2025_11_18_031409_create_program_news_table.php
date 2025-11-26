<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('tag')->nullable();
            $table->string('card_type');
            $table->string('sold_count')->nullable();
            $table->json('features');
            $table->string('price');
            $table->string('link');
            $table->enum('type', ['bimbel', 'tryout', 'bundle']);
            $table->enum('major', ['keperawatan', 'kebidanan', 'gizi']);
            $table->enum('level', ['d3', 'profesi', 's1']);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_news');
    }
};
