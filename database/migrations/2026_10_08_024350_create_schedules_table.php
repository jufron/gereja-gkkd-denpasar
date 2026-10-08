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
        // Jadwal pertemuan & ibadah jemaat. Relasi N jadwal -> 1 badge.
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('badge_id')->constrained()->cascadeOnDelete();
            $table->string('title');                         // Nama kegiatan, mis. "Komsel"
            $table->string('time');                          // Waktu, mis. "Pukul 19.30 WITA"
            $table->string('day');                           // Hari, mis. "Kamis / Jumat"
            $table->text('description');                     // Deskripsi kegiatan
            $table->unsignedInteger('sort_order')->default(0); // Urutan tampil
            $table->boolean('is_active')->default(true);     // Hanya yang aktif ditampilkan
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
