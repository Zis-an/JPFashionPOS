<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductCategory>
 */
class ProductCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ProductCategory::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,  // Generate a unique random name
            'slug' => $this->faker->unique()->slug,  // Generate a unique slug from the name
            'parent_id' => $this->faker->optional()->randomElement(ProductCategory::pluck('id')->toArray()), // Randomly assign a parent category or null
        ];
    }
}
