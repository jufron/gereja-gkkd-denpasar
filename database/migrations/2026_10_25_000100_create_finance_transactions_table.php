<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finance_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finance_category_id')->constrained()->restrictOnDelete();
            $table->date('transaction_date');
            $table->unsignedBigInteger('amount');           // rupiah utuh, tanpa desimal
            $table->string('description', 255);
            $table->string('reference_no', 50)->nullable(); // no. kwitansi/bukti
            $table->string('status', 10)->default('posted'); // posted | void
            $table->timestamp('voided_at')->nullable();
            $table->string('void_reason', 255)->nullable();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();

            $table->index('transaction_date');
            $table->index(['finance_category_id', 'transaction_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_transactions');
    }
};
