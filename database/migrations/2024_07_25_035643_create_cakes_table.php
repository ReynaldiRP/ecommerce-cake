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
            $table->foreignId('category_id')
                ->constrained(
                    table: 'categories',
                    column: 'id',
                    indexName: 'cake_category_id'
                )->onDelete('cascade');
            $table->string('name', 255);
            $table->integer('size');
            $table->integer('base_price');
            $table->string('image_url', 255)->nullable();
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
