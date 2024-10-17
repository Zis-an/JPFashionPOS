<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Production;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Size;
use App\Models\Color;

class ProductionProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch or create related entities
        $productions = Production::all();
        $products = Product::all();
        $brands = Brand::all();
        $sizes = Size::all();
        $colors = Color::all();

        // Check if any entities exist
        if ($productions->isEmpty() || $products->isEmpty() || $brands->isEmpty() || $sizes->isEmpty() || $colors->isEmpty()) {
            // Create dummy data
            // Here, adjust the number of records you want to create
            \App\Models\Production::factory(5)->create();
            \App\Models\Product::factory(5)->create();
            \App\Models\Brand::factory(5)->create();
            \App\Models\Size::factory(5)->create();
            \App\Models\Color::factory(5)->create();

            // Refresh the collections after creating
            $productions = Production::all();
            $products = Product::all();
            $brands = Brand::all();
            $sizes = Size::all();
            $colors = Color::all();
        }

        // Insert data for the pivot table
        foreach ($productions as $production) {
            DB::table('production_product')->insert([
                'production_id' => $production->id,
                'product_id' => $products->random()->id,
                'brand_id' => $brands->random()->id,
                'size_id' => $sizes->random()->id,
                'color_id' => $colors->random()->id,
                'per_pc_cost' => rand(10, 100), // Example per piece cost
                'quantity' => rand(1, 100), // Example quantity
                'sub_total' => rand(100, 1000), // Example subtotal
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
