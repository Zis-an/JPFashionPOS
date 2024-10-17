<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class RawMaterialPurchaseFactory extends Factory
{
    public function definition()
    {
        return [
            'supplier_id' => Supplier::factory()->create()->id,
            'warehouse_id' => Warehouse::factory()->create()->id,
            'account_id' => Account::factory()->create()->id,
            'purchase_date' => $this->faker->date(),
            'cost_details' => json_encode([
                'transportation' => $this->faker->randomFloat(2, 50, 200),
                'handling' => $this->faker->randomFloat(2, 20, 150),
                'tax' => $this->faker->randomFloat(2, 5, 100),
            ]),
            'total_cost' => $this->faker->randomFloat(2, 500, 1000),
            'total_price' => $this->faker->randomFloat(2, 800, 1500),
            'amount' => $this->faker->randomFloat(2, 500, 1200),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}

