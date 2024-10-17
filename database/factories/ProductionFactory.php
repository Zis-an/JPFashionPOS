<?php

namespace Database\Factories;

use App\Models\Production;
use App\Models\ProductionHouse;
use App\Models\Showroom;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionFactory extends Factory
{
    protected $model = Production::class;

    public function definition(): array
    {
        return [
            'production_house_id' => ProductionHouse::factory(),
            'showroom_id' => Showroom::factory(),
            'account_id' => Account::factory(),
            'production_date' => $this->faker->date(),
            'cost_details' => json_encode([
                'raw_material_cost' => $this->faker->randomFloat(2, 1000, 5000),
                'product_cost' => $this->faker->randomFloat(2, 2000, 6000),
            ]),
            'total_cost' => $this->faker->randomFloat(2, 3000, 10000),
            'total_raw_material_cost' => $this->faker->randomFloat(2, 1000, 3000),
            'total_product_cost' => $this->faker->randomFloat(2, 2000, 4000),
            'amount' => $this->faker->randomFloat(2, 500, 2000),
            'status' => 'pending',
        ];
    }
}
