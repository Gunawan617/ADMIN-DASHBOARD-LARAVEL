<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->enum('audience_type', ['nurse', 'midwife'])->default('nurse')->after('category');
            $table->string('buy_link')->nullable()->after('cover_image');
            $table->enum('status', ['draft', 'published'])->default('published')->after('buy_link');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['audience_type', 'buy_link', 'status']);
        });
    }
};
