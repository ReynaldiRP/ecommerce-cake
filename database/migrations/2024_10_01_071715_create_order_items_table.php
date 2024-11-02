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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained(
                table: 'orders',
                column: 'id',
                indexName: 'order_items_order_id'
            )->onDelete('cascade');
            $table->foreignId('cake_id')->constrained(
                table: 'cakes',
                column: 'id',
                indexName: 'order_items_cake_id'
            )->onDelete('cascade');
            $table->foreignId('cake_flavour_id')->nullable()->constrained(
                table: 'flavours',
                column: 'id',
                indexName: 'order_items_cake_flavour_id'
            )->onDelete('cascade');
            $table->integer('quantity');
            $table->double('price');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
