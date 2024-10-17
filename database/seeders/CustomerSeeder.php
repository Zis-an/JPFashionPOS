<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        // Create 50 sample customers
        Customer::factory()->count(50)->create();
    }
}

