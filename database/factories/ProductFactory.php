<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Size;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,  // Generate a unique random name
            'category_id' => ProductCategory::factory(), // Associate a random category
            'details' => $this->faker->paragraph,  // Detailed description
            'short_details' => $this->faker->sentence,  // Short description
            'sku' => $this->faker->unique()->word,  // Unique SKU
            'unit_id' => $this->faker->optional()->randomElement(Unit::pluck('id')->toArray()), // Randomly assign a unit or null
            'brand_id' => $this->faker->optional()->randomElement(Brand::pluck('id')->toArray()), // Randomly assign a brand or null
            'color_id' => $this->faker->optional()->randomElement(Color::pluck('id')->toArray()), // Randomly assign a brand or null
            'size_id' => $this->faker->optional()->randomElement(Size::pluck('id')->toArray()), // Randomly assign a brand or null
            'width' => $this->faker->randomFloat(2, 1, 100), // Random width between 1 and 100
            'length' => $this->faker->randomFloat(2, 1, 100), // Random length between 1 and 100
            'density' => $this->faker->randomFloat(2, 1, 10), // Random density between 1 and 10
            'thumbnail' => $this->faker->imageUrl(), // Random thumbnail image URL
            'images' => json_encode([$this->faker->imageUrl(), $this->faker->imageUrl()]), // Random array of image URLs
            'slug' => $this->faker->unique()->slug, // Generate a unique slug
        ];
    }
}
