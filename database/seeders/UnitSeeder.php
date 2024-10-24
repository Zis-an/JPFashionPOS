<?php
//
//namespace Database\Seeders;
//
//use App\Models\Unit;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
//use Illuminate\Database\Seeder;
//
//class UnitSeeder extends Seeder
//{
//    /**
//     * Run the database seeds.
//     */
//    public function run(): void
//    {
//        $this->faker->unique(true);
//        Unit::factory()->count(20)->create();
//    }
//}


namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed the units table with 20 entries
        Unit::factory()->count(10)->create();
    }
}
