<?php

namespace Database\Factories;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class WarehouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Warehouse::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company, // Generate a random company name
            'address' => $this->faker->address, // Generate a random address
            'phone' => $this->faker->phoneNumber, // Generate a random phone number
            'email' => $this->faker->unique()->safeEmail, // Generate a unique email
            'status' => $this->faker->randomElement(['active', 'inactive']), // Randomly assign status
        ];
    }
}
