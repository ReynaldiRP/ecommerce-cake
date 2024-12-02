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
        Schema::create('cakes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->foreignId('category_id')
                ->constrained(
                    table: 'categories',
                    column: 'id',
                    indexName: 'cakes_category_id_index',
                )
                ->onDelete('cascade');
            $table->foreignId('discount_id')
                ->nullable()
                ->constrained(
                    table: 'discounts',
                    column: 'id',
                    indexName: 'cakes_discount_id_index',
                )
                ->onDelete('set null');
            $table->string('image_url', 255)->nullable();
            $table->double('base_price', 8, 2);
            $table->text('description')->nullable();
            $table->enum('personalization_type', ['customized', 'non-customized']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cakes');
    }
};
