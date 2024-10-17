<?php

namespace Database\Factories;

use App\Models\RawMaterialCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RawMaterialCategory>
 */
class RawMaterialCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = RawMaterialCategory::class;

    public function definition()
    {
        // Ensure uniqueness with a custom method
        return [
            'name' => $this->uniqueName(),
        ];
    }

    protected function uniqueName()
    {
        $names = [];
        while (count($names) < 10) { // or however many you want to generate
            $name = $this->faker->word;
            if (!in_array($name, $names)) {
                $names[] = $name;
                // You might want to check if it already exists in the database
            }
        }
        return $names[array_rand($names)];
    }
}
