<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formulir', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('whatsapp');
            $table->enum('jenis_program', ['bimbel', 'tryout']);
            $table->text('pesan')->nullable();
            $table->enum('status', ['pending', 'contacted', 'registered'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formulir');
    }
};
