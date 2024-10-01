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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained(
                table: 'orders',
                column: 'id',
                indexName: 'transaction_order_id'
            )->onDelete('cascade'); // Links to the order
            $table->foreignId('payment_id')->nullable()->constrained(
                table: 'payments',
                column: 'id',
                indexName: 'transaction_payment_id'
            )->onDelete('cascade'); // Links to the payment (if it's a payment transaction)
            $table->double('amount'); // The amount involved in this transaction
            $table->string('transaction_status'); // e.g., 'success', 'failed', 'pending'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
