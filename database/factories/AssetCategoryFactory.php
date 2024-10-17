<?php

namespace Database\Factories;

use App\Models\AssetCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssetCategory>
 */
class AssetCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = AssetCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
        ];
    }
}
