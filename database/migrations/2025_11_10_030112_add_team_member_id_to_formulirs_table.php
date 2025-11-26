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
        Schema::table('formulir', function (Blueprint $table) {
            $table->unsignedBigInteger('team_member_id')->nullable()->after('jenis_program');
            $table->foreign('team_member_id')->references('id')->on('team_members')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formulir', function (Blueprint $table) {
            $table->dropForeign(['team_member_id']);
            $table->dropColumn('team_member_id');
        });
    }
};
