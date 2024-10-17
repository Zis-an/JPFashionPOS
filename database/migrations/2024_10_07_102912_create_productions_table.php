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
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_house_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('showroom_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();
            $table->date('production_date');
            $table->json('cost_details');
            $table->decimal('total_cost');
            $table->decimal('total_raw_material_cost');
            $table->decimal('total_product_cost');
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
