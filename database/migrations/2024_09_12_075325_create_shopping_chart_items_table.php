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
        Schema::create('shopping_chart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shopping_chart_id')->constrained(
                table: 'shopping_charts',
                column: 'id',
                indexName: 'shopping_chart_items_shopping_chart_id_index',
            )->cascadeOnDelete();
            $table->foreignId('cake_id')->constrained(
                table: 'cakes',
                column: 'id',
                indexName: 'shopping_chart_items_cake_id_index',
            )->cascadeOnDelete();
            $table->foreignId('cake_size_id')->nullable()->constrained(
                table: 'cake_sizes',
                column: 'id',
                indexName: 'shopping_chart_items_cake_size_id_index',
            )->cascadeOnDelete();
            $table->foreignId('cake_flavour_id')->nullable()->constrained(
                table: 'flavours',
                column: 'id',
                indexName: 'shopping_chart_items_cake_flavour_id_index',
            )->cascadeOnDelete();
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
        Schema::dropIfExists('shopping_chart_items');
    }
};
