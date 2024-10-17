<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RawMaterialStock;

class RawMaterialStockSeeder extends Seeder
{
    public function run()
    {
        RawMaterialStock::factory()->count(50)->create();
    }
}
