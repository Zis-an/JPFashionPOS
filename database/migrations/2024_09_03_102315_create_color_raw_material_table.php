<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorRawMaterialTable extends Migration
{
    public function up()
    {
        Schema::create('color_raw_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raw_material_id')->constrained('raw_materials')->onDelete('cascade');
            $table->foreignId('color_id')->constrained('colors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('color_raw_material');
    }
};
