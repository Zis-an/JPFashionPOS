<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\RawMaterial;

class BrandRawMaterialSeeder extends Seeder
{
    public function run()
    {
        // Get all brands and raw materials
        $brands = Brand::all();
        $rawMaterials = RawMaterial::all();

        // Seed the pivot table
        foreach ($brands as $brand) {
            $brand->rawMaterials()->attach(
                $rawMaterials->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
