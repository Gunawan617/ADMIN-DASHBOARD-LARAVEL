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
        Schema::table('users', function (Blueprint $table) {
            $table->string('batch')->nullable()->after('email'); // Angkatan
            $table->string('major')->nullable()->after('batch'); // Jurusan (Perawat/Bidan)
            $table->string('phone')->nullable()->after('major'); // Nomor telepon
            $table->string('photo')->nullable()->after('phone'); // Foto profil
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['batch', 'major', 'phone', 'photo']);
        });
    }
};
