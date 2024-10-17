<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sell;

class SellSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 sells
        Sell::factory(20)->create();
    }
}
