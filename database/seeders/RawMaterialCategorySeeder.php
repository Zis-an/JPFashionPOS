<?php

namespace Database\Seeders;

use App\Models\RawMaterialCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RawMaterialCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RawMaterialCategory::factory()->count(20)->create();
    }
}
