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
        // Label kategori yang menempel pada jadwal (mis. "Tim Pelayanan", "Komunitas Sel").
        // Dipisah ke tabel sendiri agar satu badge dapat dipakai banyak jadwal.
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // Label yang tampil, mis. "Tim Pelayanan"
            $table->string('slug')->unique();                // Identifier stabil, mis. "tim-pelayanan"
            $table->string('color')->nullable();             // Kelas Tailwind, mis. "bg-accent/10 text-accent"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
