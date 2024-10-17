<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;
use App\Models\RawMaterial;

class ColorRawMaterialSeeder extends Seeder
{
    public function run()
    {
        // Get all colors and raw materials
        $colors = Color::all();
        $rawMaterials = RawMaterial::all();

        // Seed the pivot table
        foreach ($rawMaterials as $rawMaterial) {
            $rawMaterial->colors()->attach(
                $colors->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}

