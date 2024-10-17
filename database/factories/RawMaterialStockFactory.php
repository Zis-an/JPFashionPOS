<?php

namespace Database\Factories;

use App\Models\RawMaterialStock;
use App\Models\RawMaterial;
use App\Models\Color;
use App\Models\Brand;
use App\Models\Size;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class RawMaterialStockFactory extends Factory
{
    protected $model = RawMaterialStock::class;

    public function definition()
    {
        // Create the related records before referencing them
        return [
            'raw_material_id' => RawMaterial::factory(), // Ensure RawMaterial is created first
            'quantity' => $this->faker->numberBetween(1, 1000),
            'price' => $this->faker->randomFloat(2, 10, 500), // Random price
            'color_id' => Color::factory(), // Ensure Color is created
            'brand_id' => Brand::factory(), // Ensure Brand is created
            'size_id' => Size::factory(), // Ensure Size is created
            'warehouse_id' => Warehouse::factory(), // Ensure Warehouse is created
        ];
    }
}
