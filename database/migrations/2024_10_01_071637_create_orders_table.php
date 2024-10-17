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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(
                table: 'users',
                column: 'id',
                indexName: 'order_user_id'
            )->onDelete('cascade');
            $table->uuid('order_code')->unique();
            $table->date('estimated_delivery_date');
            $table->string('user_address', 255);
            $table->string('cake_recipent', 255);
            $table->double('total_price');
            $table->string('status', 255);
            $table->string('checkout_link')->nullable(); // Link to the payment gateway
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
