<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'rate' => $this->faker->randomFloat(4, 0.5, 2.0), // Random exchange rate between 0.5 and 2.0
            'status' => true, // Active by default
            'is_default' => false, // Not default by default
        ];
    }

    /**
     * Indicate that the currency is the default.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function defaultCurrency(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_default' => true,
                'rate' => 1.0, // Default currency has a rate of 1.0
            ];
        });
    }
}
