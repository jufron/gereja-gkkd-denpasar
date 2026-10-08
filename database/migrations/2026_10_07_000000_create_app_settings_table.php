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
        // Penyimpanan pengaturan aplikasi bergaya key-value agar fleksibel
        // menampung segala jenis konfigurasi (umum, kontak, donasi, sosial, SEO, dll).
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->default('general'); // Kategori: general | contact | donation | social | seo ...
            $table->string('key')->unique();              // Identifier unik, mis. "contact.whatsapp_number"
            $table->text('value')->nullable();            // Nilai disimpan sebagai teks, di-cast sesuai "type"
            $table->string('type')->default('string');    // string | text | integer | boolean | json
            $table->string('description')->nullable();    // Keterangan untuk admin
            $table->boolean('is_public')->default(false); // Apakah boleh diakses sisi frontend
            $table->timestamps();

            $table->index('group');
            $table->index('is_public');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
