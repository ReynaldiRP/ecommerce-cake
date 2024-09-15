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
        Schema::create('shopping_chart_item_topping', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shopping_chart_item_id')->constrained(
                table: 'shopping_chart_items',
                column: 'id',
                indexName: 'shopping_chart_item_topping_shopping_chart_item_id_index',
            );
            $table->foreignId('topping_id')->constrained(
                table: 'toppings',
                column: 'id',
                indexName: 'shopping_chart_item_topping_topping_id_index'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_chart_item_toppings');
    }
};
