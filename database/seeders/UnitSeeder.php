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
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    public function run()
    {
        $units = [
            ['code' => 'kg', 'name' => 'Kilogram'],
            ['code' => 'ton', 'name' => 'Ton'],
            ['code' => 'gram', 'name' => 'Gram'],
            ['code' => 'mg', 'name' => 'Milligram'],
            ['code' => 'lb', 'name' => 'Pound'],
            ['code' => 'oz', 'name' => 'Ounce']
        ];

        foreach ($units as $unit) {
            DB::table('units')->updateOrInsert(
                ['code' => $unit['code']], // Check for existing 'code'
                [
                    'name' => $unit['name'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );
        }
    }
}
