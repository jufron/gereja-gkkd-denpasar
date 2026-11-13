<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sermon_evaluations', function (Blueprint $table) {
            if (Schema::hasColumn('sermon_evaluations', 'topik_diminta')) {
                $table->dropColumn('topik_diminta');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sermon_evaluations', function (Blueprint $table) {
            if (! Schema::hasColumn('sermon_evaluations', 'topik_diminta')) {
                $table->string('topik_diminta', 500)->nullable();
            }
        });
    }
};
