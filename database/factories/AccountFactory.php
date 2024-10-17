<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Account::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company, // Unique name for the account
            'type' => $this->faker->randomElement(['Cash', 'Bank', 'MFS']), // Random account type
            'balance' => $this->faker->randomFloat(2, 100, 10000), // Random balance between 100 and 10000
            'admin_id' => Admin::inRandomOrder()->first()->id ?? Admin::factory(), // Random or new Admin
            'status' => $this->faker->randomElement(['active', 'deactivate']), // Random status
        ];
    }
}
