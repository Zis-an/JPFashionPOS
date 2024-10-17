<?php

namespace Database\Factories;

use App\Models\RawMaterial;
use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

class SizeRawMaterialFactory extends Factory
{
    protected $model = \Illuminate\Database\Eloquent\Model::class; // No specific model

    public function definition()
    {
        return [
            'raw_material_id' => RawMaterial::factory()->create()->id,
            'size_id' => Size::factory()->create()->id,
        ];
    }
}
