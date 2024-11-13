<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRawMaterialsTable extends Migration
{
    public function up()
    {
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('raw_material_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete();
            $table->string('sku')->unique();
            $table->string('image')->nullable();
            $table->text('details')->nullable();
            $table->decimal('width', 16, 2)->nullable();
            $table->decimal('length', 16, 2)->nullable();
            $table->decimal('density', 16, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('raw_materials');
    }
};
