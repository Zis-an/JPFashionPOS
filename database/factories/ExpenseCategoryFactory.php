<?php

namespace Database\Factories;

use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExpenseCategory>
 */
class ExpenseCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ExpenseCategory::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,  // Generate unique category name
        ];
    }
}
