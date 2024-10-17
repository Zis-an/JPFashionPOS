<?php

namespace Database\Seeders;

use App\Models\RawMaterial;
use App\Models\Size;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeRawMaterialSeeder extends Seeder
{
    public function run()
    {
        // Create 100 sample size_raw_material records
        for ($i = 0; $i < 100; $i++) {
            DB::table('size_raw_material')->insert([
                'raw_material_id' => RawMaterial::factory()->create()->id,
                'size_id' => Size::factory()->create()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

