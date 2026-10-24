<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_id')->constrained('media')->cascadeOnDelete();
            $table->foreignId('news_id')->constrained('news')->cascadeOnDelete();
            $table->string('kind')->default('content'); // content | banner
            $table->timestamps();

            $table->unique(['media_id', 'news_id', 'kind'], 'asset_usage_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_usages');
    }
};
