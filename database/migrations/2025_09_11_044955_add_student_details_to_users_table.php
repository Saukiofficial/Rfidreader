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
            // Kolom spesifik untuk siswa
            $table->string('nis')->after('role')->unique()->nullable();
            $table->string('class')->after('nis')->nullable(); // misal: 'X RPL 1', 'XI TKJ 2'
            $table->string('card_uid')->after('class')->unique()->nullable(); // UID dari kartu RFID

            // Kolom spesifik untuk wali murid
            $table->string('guardian_name')->after('card_uid')->nullable();
            $table->string('guardian_phone')->after('guardian_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nis',
                'class',
                'card_uid',
                'guardian_name',
                'guardian_phone'
            ]);
        });
    }
};
