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
        Schema::create('production_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_id');
            $table->unsignedBigInteger('product_id');
            $table->foreignId('brand_id');
            $table->foreignId('size_id');
            $table->foreignId('color_id');
            $table->double('per_pc_cost');
            $table->unsignedBigInteger('quantity');
            $table->double('sub_total');
            $table->timestamps();

            $table->foreign('production_id')->references('id')->on('productions')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_product');
    }
};
