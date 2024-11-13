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
        Schema::create('product_stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique()->nullable();
            $table->date('date');
            $table->string('status');
            $table->foreignId('from_showroom_id')->constrained('showrooms')->onDelete('cascade');
            $table->foreignId('to_showroom_id')->constrained('showrooms')->onDelete('cascade');
            $table->text('note')->nullable();
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_stock_transfers');
    }
};
