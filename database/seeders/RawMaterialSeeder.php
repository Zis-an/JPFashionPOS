<?php

namespace Database\Seeders;

use App\Models\RawMaterial;
use App\Models\RawMaterialCategory;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create categories and units first
        RawMaterialCategory::factory()->count(10)->create();
        Unit::factory()->count(10)->create();

        // Then create RawMaterials
        RawMaterial::factory()->count(50)->create();
    }
}
