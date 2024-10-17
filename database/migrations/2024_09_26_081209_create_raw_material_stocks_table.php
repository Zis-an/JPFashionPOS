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
        Schema::create('raw_material_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('raw_material_id');
            $table->double('quantity');
            $table->double('price');
            $table->unsignedBigInteger('color_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('size_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->timestamps();
            $table->softDeletes();

            // Assuming the referenced tables are `colors`, `brands`, and `sizes`
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_material_stocks');
    }
};
