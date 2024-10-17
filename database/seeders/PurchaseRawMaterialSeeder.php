<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\RawMaterialPurchase;
use App\Models\RawMaterial;
use App\Models\Brand;
use App\Models\Size;
use App\Models\Color;
use App\Models\Warehouse;

class PurchaseRawMaterialSeeder extends Seeder
{
    public function run()
    {
        // Create 100 sample purchase raw material records
        for ($i = 0; $i < 100; $i++) {
            // Generate values using factories
            $rawMaterialPurchase = RawMaterialPurchase::factory()->create();
            $rawMaterial = RawMaterial::factory()->create();
            $brand = Brand::factory()->create();
            $size = Size::factory()->create();
            $color = Color::factory()->create();
            $warehouse = Warehouse::factory()->create();

            $price = rand(10, 500);
            $quantity = rand(1, 100);
            $totalPrice = $price * $quantity;

            DB::table('purchase_raw_material')->insert([
                'raw_material_purchase_id' => $rawMaterialPurchase->id,
                'raw_material_id' => $rawMaterial->id,
                'brand_id' => $brand->id,
                'size_id' => $size->id,
                'color_id' => $color->id,
                'warehouse_id' => $warehouse->id,
                'price' => $price,
                'quantity' => $quantity,
                'total_price' => $totalPrice, // Use the computed value
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
