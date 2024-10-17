<?php

namespace Database\Factories;

use App\Models\Color;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Color>
 */
class ColorFactory extends Factory
{
    protected $model = Color::class;

    public function definition()
    {
        // Define a limited set of colors
        $colors = ['Red', 'Green', 'Blue', 'Yellow', 'Purple', 'Orange', 'Pink', 'Brown', 'Gray', 'Black'];

        return [
            'color_code' => $this->faker->hexColor,  // Not unique, could be the same for different colors
            'color_name' => $this->faker->randomElement($colors), // Color name can repeat
        ];
    }
}

