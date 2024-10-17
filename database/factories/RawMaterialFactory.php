<?php

namespace Database\Factories;

use App\Models\RawMaterial;
use App\Models\RawMaterialCategory;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RawMaterial>
 */
class RawMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = RawMaterial::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->words(2, true), // Ensure the name is unique
            'raw_material_category_id' => RawMaterialCategory::factory(), // Create a related category
            'unit_id' => Unit::factory(), // Create a related unit
            'sku' => $this->faker->unique()->lexify('SKU???'), // Ensure the SKU is unique
            'image' => $this->faker->imageUrl(), // Random image URL
            'details' => $this->faker->text(200), // Random details
            'width' => $this->faker->randomFloat(2, 0, 100), // Random width
            'length' => $this->faker->randomFloat(2, 0, 100), // Random length
            'density' => $this->faker->randomFloat(2, 0, 100), // Random density
        ];
    }

}
