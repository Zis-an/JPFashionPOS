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
        // Initialize a variable to hold the generated name
        $sl = 0;

        // Ensure uniqueness with a do-while loop
        do {
            if ($sl){
                $name = $this->faker->word.$sl;
            }else{
                $name = $this->faker->word;
            }
            // Generate a random word for the name
            $sl ++;
        } while (RawMaterial::where('name', $name)->exists()); // Check if it exists

        return [
            'name' => $name, // Generate a unique random name
            'raw_material_category_id' => RawMaterialCategory::factory(), // Use a random category
            'unit_id' => Unit::factory(), // Use a random unit
            'sku' => $this->faker->unique()->word, // Generate a unique SKU
            'image' => $this->faker->imageUrl(), // Generate a random image URL
            'details' => $this->faker->text(200), // Generate random details
            'width' => $this->faker->randomFloat(2, 0, 100), // Generate random width
            'length' => $this->faker->randomFloat(2, 0, 100), // Generate random length
            'density' => $this->faker->randomFloat(2, 0, 100), // Generate random density
        ];
    }
}
