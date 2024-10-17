<?php

namespace Database\Factories;

use App\Models\Color;
use App\Models\RawMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

class ColorRawMaterialFactory extends Factory
{
    public function definition()
    {
        return [
            'color_id' => Color::factory(),
            'raw_material_id' => RawMaterial::factory(),
        ];
    }
}
