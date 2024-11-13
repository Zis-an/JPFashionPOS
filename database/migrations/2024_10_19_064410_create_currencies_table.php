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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique(); // e.g., USD, EUR, GBP
            $table->string('name');
            $table->double('rate',16,2); // Exchange rate relative to the default currency
            $table->string('suffix')->nullable();
            $table->string('prefix')->nullable();

            $table->boolean('status')->default(true); // Active or inactive currency
            $table->boolean('is_default')->default(false); // Only one record can have this set to true
            $table->timestamps();
            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
