<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Production;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 productions
        Production::factory(20)->create();
    }
}
