<?php

namespace Database\Factories;

use App\Models\ProductionHouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionHouseFactory extends Factory
{
    protected $model = ProductionHouse::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'balance' => $this->faker->randomFloat(2, 1000, 10000), // Random balance between 1,000 and 10,000
            'status' => 'active',
        ];
    }
}
