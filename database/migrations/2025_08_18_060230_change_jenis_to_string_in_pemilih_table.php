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
        // Ubah kolom 'jenis' dari enum menjadi string
        Schema::table('pemilih', function (Blueprint $table) {
            $table->string('jenis')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan kolom 'jenis' menjadi enum
        Schema::table('pemilih', function (Blueprint $table) {
            $table->enum('jenis', ['siswa', 'guru'])->change();
        });
    }
};