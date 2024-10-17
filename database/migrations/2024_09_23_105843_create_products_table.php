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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->text('details')->nullable();
            $table->text('short_details')->nullable();
            $table->string('sku')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('size_id')->nullable();
            $table->float('width')->nullable();
            $table->float('length')->nullable();
            $table->float('density')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('images')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
