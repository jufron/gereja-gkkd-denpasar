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
        // Profil jemaat. Relasi one-to-one: 1 akun user -> 1 profil.
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            // Identitas
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat')->nullable();

            // Keanggotaan
            $table->string('status_anggota')->default('aktif'); // aktif | nonaktif | pindah | meninggal
            $table->date('tanggal_bergabung')->nullable();

            // WhatsApp
            $table->string('no_hp', 20)->nullable();            // Format E.164, mis. 6281234567890
            $table->boolean('wa_consent')->default(false);      // Izin kirim pesan
            $table->timestamp('wa_verified_at')->nullable();    // Nomor terverifikasi di WhatsApp

            $table->timestamps();

            $table->index('status_anggota');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
