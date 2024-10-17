<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\RawMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandRawMaterialFactory extends Factory
{
    public function definition()
    {
        return [
            'brand_id' => Brand::factory(),
            'raw_material_id' => RawMaterial::factory(),
        ];
    }
}
