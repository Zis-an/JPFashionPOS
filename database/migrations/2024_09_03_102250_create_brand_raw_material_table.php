<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandRawMaterialTable extends Migration
{
    public function up()
    {
        Schema::create('brand_raw_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raw_material_id')->constrained('raw_materials')->onDelete('cascade');
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brand_raw_material');
    }
};
