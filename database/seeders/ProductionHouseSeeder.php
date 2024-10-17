<?php

namespace Database\Seeders;

use App\Models\ProductionHouse;
use Illuminate\Database\Seeder;

class ProductionHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 Production Houses with the factory
        ProductionHouse::factory()->count(20)->create();
    }
}
