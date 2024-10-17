<?php

namespace Database\Factories;

use App\Models\PurchaseRawMaterial; // Ensure the correct model is used
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseRawMaterialFactory extends Factory
{
    protected $model = PurchaseRawMaterial::class; // Use the correct model

    public function definition()
    {
        $price = $this->faker->randomFloat(2, 10, 500);
        $quantity = $this->faker->randomFloat(0, 1, 100);
        $total_price = $price * $quantity;

        return [
            'raw_material_purchase_id' => RawMaterialPurchase::factory(),
            'raw_material_id' => RawMaterial::factory(),
            'brand_id' => Brand::factory(),
            'size_id' => Size::factory(),
            'color_id' => Color::factory(),
            'warehouse_id' => Warehouse::factory(),
            'price' => $price,
            'quantity' => $quantity,
            'total_price' => $total_price,
        ];
    }
}
