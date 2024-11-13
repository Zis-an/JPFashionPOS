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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('hire_date');
            $table->string('position');
            $table->unsignedBigInteger('department_id');
            $table->string('education_level')->nullable();
            $table->json('ed_certificate')->nullable();
            $table->unsignedBigInteger('nid');
            $table->float('service_days');
            $table->string('gender')->default('male');
            $table->decimal('salary', 16, 2);
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
