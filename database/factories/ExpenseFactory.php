<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Expense::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),  // Random title for the expense
            'expense_category_id' => ExpenseCategory::factory(),  // Create or assign a category
            'account_id' => Account::factory(),  // Create or assign an account
            'amount' => $this->faker->randomFloat(2, 100, 10000),  // Random amount between 100 and 10,000
            'details' => $this->faker->sentence(10),  // Optional expense details
            'images' => json_encode([$this->faker->imageUrl(640, 480)]),  // Optional images in JSON format
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),  // Random status
        ];
    }
}
