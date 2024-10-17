<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Asset;
use App\Models\AssetCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Asset::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word, // Random asset name
            'asset_category_id' => AssetCategory::inRandomOrder()->first()->id ?? AssetCategory::factory(), // Random or new Asset Category
            'amount' => $this->faker->randomFloat(2, 1000, 100000), // Random amount between 1,000 and 100,000
            'details' => $this->faker->sentence(), // Random details text
            'account_id' => Account::inRandomOrder()->first()->id ?? Account::factory(), // Random or new Account (nullable)
            'images' => $this->faker->imageUrl(), // Fake image URL (nullable)
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']), // Random status
        ];
    }
}
