<?php

namespace Database\Seeders;

use App\Models\Showroom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShowroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Showroom::factory()->count(20)->create();
    }
}
