<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Production;
use App\Models\RawMaterial;
use App\Models\Brand;
use App\Models\Size;
use App\Models\Color;
use App\Models\Warehouse;

class ProductionRawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch or create related entities
        $productions = Production::all();
        $rawMaterials = RawMaterial::all();
        $brands = Brand::all();
        $sizes = Size::all();
        $colors = Color::all();
        $warehouses = Warehouse::all();

        // Check if any entities exist
        if ($productions->isEmpty() || $rawMaterials->isEmpty() || $brands->isEmpty() || $sizes->isEmpty() || $colors->isEmpty() || $warehouses->isEmpty()) {
            // Create dummy data
            \App\Models\Production::factory(5)->create();
            \App\Models\RawMaterial::factory(5)->create();
            \App\Models\Brand::factory(5)->create();
            \App\Models\Size::factory(5)->create();
            \App\Models\Color::factory(5)->create();
            \App\Models\Warehouse::factory(5)->create();

            // Refresh the collections after creating
            $productions = Production::all();
            $rawMaterials = RawMaterial::all();
            $brands = Brand::all();
            $sizes = Size::all();
            $colors = Color::all();
            $warehouses = Warehouse::all();
        }

        // Insert data for the pivot table
        foreach ($productions as $production) {
            DB::table('production_raw_materials')->insert([
                'production_id' => $production->id,
                'raw_material_id' => $rawMaterials->random()->id,
                'brand_id' => $brands->random()->id,
                'size_id' => $sizes->random()->id,
                'color_id' => $colors->random()->id,
                'warehouse_id' => $warehouses->random()->id,
                'price' => rand(10, 100), // Example price
                'quantity' => rand(1, 100), // Example quantity
                'total_price' => rand(100, 1000), // Example total price
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
