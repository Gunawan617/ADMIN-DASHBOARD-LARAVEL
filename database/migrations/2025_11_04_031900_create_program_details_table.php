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
        Schema::create('program_details', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('product_type'); // bimbel, tryout, books, video
            $table->string('audience_type'); // nurse, midwife
            $table->string('tag')->nullable();
            
            // Program Info
            $table->string('duration')->nullable();
            $table->string('students')->nullable();
            $table->string('level')->nullable();
            $table->string('price')->nullable();
            $table->string('questions')->nullable();
            $table->string('pages')->nullable();
            
            // Details
            $table->json('features')->nullable(); // Array of features
            $table->json('schedule')->nullable(); // Array of schedule items
            $table->json('benefits')->nullable(); // Array of benefits
            $table->json('packages')->nullable(); // Array of packages (for tryout)
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // Status
            $table->enum('status', ['draft', 'published'])->default('published');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_details');
    }
};
