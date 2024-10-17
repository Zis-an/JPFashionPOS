<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RawMaterialPurchase;

class RawMaterialPurchaseSeeder extends Seeder
{
    public function run()
    {
        // Create 50 raw material purchase records
        RawMaterialPurchase::factory()->count(20)->create();
    }
}

