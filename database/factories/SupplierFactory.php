<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Supplier::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company, // Generate a random company name
            'contact_person' => $this->faker->name, // Generate a random name for the contact person
            'phone' => $this->faker->phoneNumber, // Generate a random phone number
            'email' => $this->faker->unique()->safeEmail, // Generate a unique email address
            'address' => $this->faker->address, // Generate a random address
            'description' => $this->faker->paragraph, // Generate a random description
        ];
    }
}
