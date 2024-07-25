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
        Schema::create('category_flavours', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->constrained(
                    table: 'categories',
                    column: 'id',
                )->onDelete('cascade');
            $table->foreignId('flavour_id')
                ->constrained(
                    table: 'flavours',
                    column: 'id',
                )->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_flavours');
    }
};
