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
        // Kategori berita. Dipakai sebagai label/tag artikel di halaman berita
        // publik (mis. "Renungan", "Aksi Kasih") dan dikelola dari dashboard.
        Schema::create('news_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // Label yang tampil, mis. "Renungan"
            $table->string('slug')->unique();                // Identifier stabil, mis. "renungan"
            $table->string('color')->nullable();             // Kelas Tailwind, mis. "bg-blue-500/10 text-blue-600"
            $table->text('description')->nullable();         // Penjelasan singkat kategori
            $table->unsignedInteger('sort_order')->default(0); // Urutan tampil
            $table->boolean('is_active')->default(true);     // Hanya yang aktif ditampilkan di publik
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_categories');
    }
};
