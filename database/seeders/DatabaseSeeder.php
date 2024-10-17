<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        File::deleteDirectory(public_path('uploads'));
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call([
            AccountSeeder::class,
            AssetCategorySeeder::class,
            AssetSeeder::class,

            BrandSeeder::class,

            ColorSeeder::class,
            CustomerSeeder::class,
            DepartmentSeeder::class,
            EmployeeSeeder::class,
            ExpenseCategorySeeder::class,
            ExpenseSeeder::class,
            PaymentMethodSeeder::class,
            ProductCategorySeeder::class,
            ProductionHouseSeeder::class,
            ProductionSeeder::class,


            ProductSeeder::class,

            RawMaterialCategorySeeder::class,

            RawMaterialSeeder::class,


            SellSeeder::class,
            ShowroomSeeder::class,

            SizeSeeder::class,
            SupplierSeeder::class,
            UnitSeeder::class,
            UserSeeder::class,
            WarehouseSeeder::class,

            BrandRawMaterialSeeder::class,
            ColorRawMaterialSeeder::class,
            ProductionProductSeeder::class,
            ProductionRawMaterialSeeder::class,
            PurchaseRawMaterialSeeder::class,
            RawMaterialPurchaseSeeder::class,
            RawMaterialStockSeeder::class,
            SizeRawMaterialSeeder::class,
        ]);
    }
}