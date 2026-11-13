<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prayer_requests', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('nomor_hp', 20);
            $table->text('alamat')->nullable();
            $table->string('kategori', 30)->default('lainnya');
            $table->text('isi_doa');
            $table->boolean('boleh_dihubungi')->default(true);
            $table->string('status', 20)->default('baru'); // baru|diproses|selesai
            $table->text('catatan_internal')->nullable();
            $table->timestamp('didoakan_pada')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prayer_requests');
    }
};
