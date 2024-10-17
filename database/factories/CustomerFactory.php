<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomerFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address(),
            'dob' => $this->faker->date(),
            'anniversary_date' => $this->faker->date(),
            'registration_date' => $this->faker->date(),
            'family_details' => json_encode([
                'spouse_name' => $this->faker->name('female'),
                'children' => [
                    ['name' => $this->faker->name('male'), 'age' => rand(3, 12)],
                    ['name' => $this->faker->name('female'), 'age' => rand(3, 12)],
                ]
            ]),
        ];
    }
}

