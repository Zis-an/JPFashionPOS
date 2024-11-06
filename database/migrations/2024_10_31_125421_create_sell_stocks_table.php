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
        Schema::create('sell_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sell_id');
            $table->foreignId('stock_id');
            $table->double('price', 10, 2);
            $table->double('cost', 10, 2);
            $table->unsignedBigInteger('quantity');
            $table->string('discount_type');
            $table->double('discount_amount', 10, 2);
            $table->double('total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_stocks');
    }
};
