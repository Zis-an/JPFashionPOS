<?php

namespace Database\Factories;

use App\Models\Showroom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Showroom>
 */
class ShowroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Showroom::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company, // Generate a unique company name for showroom
            'address' => $this->faker->address, // Generate a random address
            'phone' => $this->faker->phoneNumber, // Generate a random phone number
            'email' => $this->faker->unique()->safeEmail, // Generate a unique random email
            'status' => 'active', // Default status
        ];
    }
}
