<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sermon_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('bulan');                       // 1-12
            $table->unsignedSmallInteger('tahun');                      // mis. 2026
            $table->string('nama', 100)->nullable();
            $table->unsignedTinyInteger('rating');                      // 1-5
            $table->text('berkesan')->nullable();
            $table->text('masukan')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->timestamps();
            $table->index(['tahun', 'bulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sermon_evaluations');
    }
};
