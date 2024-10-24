<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing currencies to avoid duplicates
        Currency::query()->delete();

        // Create default currency (USD)
        Currency::create([
            'code' => 'USD',
            'name' => 'US Dollar',
            'rate' => 1.0,
            'status' => true,
            'is_default' => true,
        ]);

        // Create additional currencies
        $currencies = [
            ['code' => 'EUR', 'name' => 'Euro', 'rate' => 0.85],
            ['code' => 'GBP', 'name' => 'British Pound', 'rate' => 0.75],
            ['code' => 'JPY', 'name' => 'Japanese Yen', 'rate' => 110.45],
            ['code' => 'CAD', 'name' => 'Canadian Dollar', 'rate' => 1.25],
            ['code' => 'AUD', 'name' => 'Australian Dollar', 'rate' => 1.30],
        ];

        foreach ($currencies as $currency) {
            Currency::create([
                'code' => $currency['code'],
                'name' => $currency['name'],
                'rate' => $currency['rate'],
                'status' => true,   // Active
                'is_default' => false, // Non-default
            ]);
        }
    }
}
