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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained(
                table: 'orders',
                column: 'id',
                indexName: 'payment_order_id'
            )->onDelete('cascade'); // Links to the order
            $table->double('amount'); // The total amount paid
            $table->string('payment_method'); // e.g., card, PayPal, etc.
            $table->string('payment_status'); // e.g., pending, completed, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
