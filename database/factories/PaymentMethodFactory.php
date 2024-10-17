<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = PaymentMethod::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,  // Generate a random company name
            'amount' => $this->faker->randomFloat(2, 50, 5000),  // Random amount between 50 and 5000
            'description' => $this->faker->sentence(10),  // Optional description
        ];
    }
}
