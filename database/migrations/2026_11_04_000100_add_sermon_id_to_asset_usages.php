<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kepemilikan khotbah di asset_usages. news_id jadi opsional,
     * sermon_id opsional; tepat salah satu terisi. Satu baris = satu
     * pemakaian media, kind mencakup content|banner (berita) dan
     * thumbnail|preacher (khotbah).
     */
    public function up(): void
    {
        Schema::table('asset_usages', function (Blueprint $table) {
            $table->dropForeign(['news_id']);

            $table->foreignId('news_id')->nullable()->change();

            $table->foreign('news_id')
                ->references('id')
                ->on('news')
                ->cascadeOnDelete();

            $table->foreignId('sermon_id')
                ->nullable()
                ->after('news_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unique(['media_id', 'sermon_id', 'kind'], 'asset_usage_sermon_unique');
        });
    }

    public function down(): void
    {
        Schema::table('asset_usages', function (Blueprint $table) {
            $table->dropUnique('asset_usage_sermon_unique');

            $table->dropConstrainedForeignId('sermon_id');

            $table->dropForeign(['news_id']);

            $table->foreignId('news_id')->change();

            $table->foreign('news_id')
                ->references('id')
                ->on('news')
                ->cascadeOnDelete();
        });
    }
};
