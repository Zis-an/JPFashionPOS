<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'address' => $this->faker->address,
            'date_of_birth' => $this->faker->date('Y-m-d', '2000-01-01'),
            'hire_date' => $this->faker->date('Y-m-d', 'now'),
            'position' => $this->faker->jobTitle,
            'department_id' => Department::factory(),  // Create or assign a department
            'education_level' => $this->faker->randomElement(['High School', 'Bachelors', 'Masters', 'PhD']),
            'ed_certificate' => json_encode(['certificate_url' => $this->faker->url]),  // Example JSON certificate data
            'nid' => $this->faker->unique()->randomNumber(9, true),
            'service_days' => $this->faker->randomFloat(2, 0, 365),  // Days of service
            'gender' => $this->faker->randomElement(['male', 'female']),
            'salary' => $this->faker->randomFloat(2, 20000, 100000),  // Random salary
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
