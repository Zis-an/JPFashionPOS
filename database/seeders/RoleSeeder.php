<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::where('name', 'super-admin')->first();
        if (!$superAdmin) {
            $superAdmin = Role::create(['name' => 'super-admin']);
            Role::create(['name' => 'admin']);
            Role::create(['name' => 'user']);
            Role::create(['name' => 'moderator']);
        }
        $permissions = [
                [
                    'group_name' => 'Commands',
                    'permissions' => [
                        'commands_manage',
                        'command_cache_clear',
                        'command_config_clear',
                        'command_route_clear',
                        'command_optimize',
                        'command_seed',
                        'command_migrate',
                        'command_migrate_fresh',
                        'command_migrate_fresh_seed',
                    ]
                ],
                [
                    'group_name' => 'Roles',
                    'permissions' => [
                        'roles.list',
                        'roles.view',
                        'roles.create',
                        'roles.update',
                        'roles.delete'
                    ]

                ],
                [
                    'group_name' => 'Permissions',
                    'permissions' => [
                        'permissions.list',
                        'permissions.create',
                        'permissions.update',
                        'permissions.delete'
                    ]

                ],
                [
                    'group_name' => 'Admins',
                    'permissions' => [
                        'admins.list',
                        'admins.create',
                        'admins.view',
                        'admins.update',
                        'admins.delete',
                        'admins.trashed',
                        'admins.restore',
                        'admins.force_delete',
                        'admins.activity',
                    ]

                ],
                [
                    'group_name' => 'Accounts',
                    'permissions' => [
                        'accounts.list',
                        'accounts.create',
                        'accounts.view',
                        'accounts.update',
                        'accounts.delete',
                        'accounts.trashed',
                        'accounts.restore',
                        'accounts.force_delete',
                        'accounts.activity',
                    ]

                ],
                [
                    'group_name' => 'Expenses',
                    'permissions' => [
                        'expenses.list',
                        'expenses.create',
                        'expenses.view',
                        'expenses.update',
                        'expenses.delete',
                        'expenses.trashed',
                        'expenses.restore',
                        'expenses.force_delete',
                        'expenses.activity',
                        'expenses.updateStatus',
                    ]

                ],
                [
                    'group_name' => 'ExpenseCategories',
                    'permissions' => [
                        'expense-categories.list',
                        'expense-categories.create',
                        'expense-categories.view',
                        'expense-categories.update',
                        'expense-categories.delete',
                        'expense-categories.trashed',
                        'expense-categories.restore',
                        'expense-categories.force_delete',
                        'expense-categories.activity',
                    ]
                ],
                [
                    'group_name' => 'Assets',
                    'permissions' => [
                        'assets.list',
                        'assets.create',
                        'assets.view',
                        'assets.update',
                        'assets.delete',
                        'assets.trashed',
                        'assets.restore',
                        'assets.force_delete',
                        'assets.activity',
                        'assets.updateStatus',
                    ]
                ],
                [
                    'group_name' => 'AssetCategories',
                    'permissions' => [
                        'asset-categories.list',
                        'asset-categories.create',
                        'asset-categories.view',
                        'asset-categories.update',
                        'asset-categories.delete',
                        'asset-categories.trashed',
                        'asset-categories.restore',
                        'asset-categories.force_delete',
                        'asset-categories.activity',
                    ]
                ],
                [
                    'group_name' => 'Units',
                    'permissions' => [
                        'units.list',
                        'units.create',
                        'units.view',
                        'units.update',
                        'units.delete',
                        'units.trashed',
                        'units.restore',
                        'units.force_delete',
                        'units.activity',
                    ]
                ],
                [
                    'group_name' => 'Colors',
                    'permissions' => [
                        'colors.list',
                        'colors.create',
                        'colors.view',
                        'colors.update',
                        'colors.delete',
                        'colors.trashed',
                        'colors.restore',
                        'colors.force_delete',
                        'colors.activity',
                    ]
                ],
                [
                    'group_name' => 'Brands',
                    'permissions' => [
                        'brands.list',
                        'brands.create',
                        'brands.view',
                        'brands.update',
                        'brands.delete',
                        'brands.trashed',
                        'brands.restore',
                        'brands.force_delete',
                        'brands.activity',
                    ]
                ],
                [
                    'group_name' => 'Sizes',
                    'permissions' => [
                        'sizes.list',
                        'sizes.create',
                        'sizes.view',
                        'sizes.update',
                        'sizes.delete',
                        'sizes.trashed',
                        'sizes.restore',
                        'sizes.force_delete',
                        'sizes.activity',
                    ]
                ],
                [
                    'group_name' => 'Suppliers',
                    'permissions' => [
                        'suppliers.list',
                        'suppliers.create',
                        'suppliers.view',
                        'suppliers.update',
                        'suppliers.delete',
                        'suppliers.trashed',
                        'suppliers.restore',
                        'suppliers.force_delete',
                        'suppliers.activity',
                    ]
                ],
                [
                    'group_name' => 'Customers',
                    'permissions' => [
                        'customers.list',
                        'customers.create',
                        'customers.view',
                        'customers.update',
                        'customers.delete',
                        'customers.trashed',
                        'customers.restore',
                        'customers.force_delete',
                        'customers.activity',
                    ]
                ],
                [
                    'group_name' => 'PaymentMethods',
                    'permissions' => [
                        'paymentMethods.list',
                        'paymentMethods.create',
                        'paymentMethods.view',
                        'paymentMethods.update',
                        'paymentMethods.delete',
                        'paymentMethods.trashed',
                        'paymentMethods.restore',
                        'paymentMethods.force_delete',
                        'paymentMethods.activity',
                    ]
                ],
                [
                    'group_name' => 'Warehouses',
                    'permissions' => [
                        'warehouses.list',
                        'warehouses.create',
                        'warehouses.view',
                        'warehouses.update',
                        'warehouses.delete',
                        'warehouses.trashed',
                        'warehouses.restore',
                        'warehouses.force_delete',
                        'warehouses.activity',
                    ]
                ],
                [
                    'group_name' => 'MaterialCategories',
                    'permissions' => [
                        'materialCategories.list',
                        'materialCategories.create',
                        'materialCategories.view',
                        'materialCategories.update',
                        'materialCategories.delete',
                        'materialCategories.trashed',
                        'materialCategories.restore',
                        'materialCategories.force_delete',
                        'materialCategories.activity',
                    ]
                ],
                [
                    'group_name' => 'RawMaterials',
                    'permissions' => [
                        'materials.list',
                        'materials.create',
                        'materials.view',
                        'materials.update',
                        'materials.delete',
                        'materials.trashed',
                        'materials.restore',
                        'materials.force_delete',
                        'materials.activity',
                    ]
                ],
                [
                    'group_name' => 'RawMaterialPurchase',
                    'permissions' => [
                        'rawMaterialPurchases.list',
                        'rawMaterialPurchases.create',
                        'rawMaterialPurchases.view',
                        'rawMaterialPurchases.update',
                        'rawMaterialPurchases.delete',
                        'rawMaterialPurchases.trashed',
                        'rawMaterialPurchases.restore',
                        'rawMaterialPurchases.force_delete',
                        'rawMaterialPurchases.activity',
                        'rawMaterialPurchases.updateStatus',
                    ]
                ],
                [
                    'group_name' => 'Showrooms',
                    'permissions' => [
                        'showrooms.list',
                        'showrooms.create',
                        'showrooms.view',
                        'showrooms.update',
                        'showrooms.delete',
                        'showrooms.trashed',
                        'showrooms.restore',
                        'showrooms.force_delete',
                        'showrooms.activity',
                    ]
                ],
                [
                    'group_name' => 'Employee',
                    'permissions' => [
                        'employees.list',
                        'employees.create',
                        'employees.view',
                        'employees.update',
                        'employees.delete',
                        'employees.trashed',
                        'employees.restore',
                        'employees.force_delete',
                        'employees.activity',
                        'employees.delete_certificate'
                    ]
                ],
                [
                    'group_name' => 'Department',
                    'permissions' => [
                        'departments.list',
                        'departments.create',
                        'departments.view',
                        'departments.update',
                        'departments.delete',
                        'departments.trashed',
                        'departments.restore',
                        'departments.force_delete',
                        'departments.activity'
                    ]
                ],
                [
                    'group_name' => 'ProductCategory',
                    'permissions' => [
                        'productCategories.list',
                        'productCategories.create',
                        'productCategories.view',
                        'productCategories.update',
                        'productCategories.delete',
                        'productCategories.trashed',
                        'productCategories.restore',
                        'productCategories.force_delete',
                        'productCategories.activity'
                    ]
                ],
                [
                    'group_name' => 'Product',
                    'permissions' => [
                        'products.list',
                        'products.create',
                        'products.view',
                        'products.update',
                        'products.delete',
                        'products.trashed',
                        'products.restore',
                        'products.force_delete',
                        'products.activity'
                    ]
                ],
                [
                    'group_name' => 'RawMaterialStock',
                    'permissions' => [
                        'rawMaterialStocks.list',
                        'rawMaterialStocks.view',
                        'rawMaterialStocks.activity'
                    ]
                ],
                [
                    'group_name' => 'Deposit',
                    'permissions' => [
                        'deposits.list',
                        'deposits.create',
                        'deposits.view',
                        'deposits.update',
                        'deposits.delete',
                        'deposits.trashed',
                        'deposits.restore',
                        'deposits.force_delete',
                        'deposits.activity',
                        'deposits.updateStatus'
                    ]
                ],
                [
                    'group_name' => 'Withdraw',
                    'permissions' => [
                        'withdraws.list',
                        'withdraws.create',
                        'withdraws.view',
                        'withdraws.update',
                        'withdraws.delete',
                        'withdraws.trashed',
                        'withdraws.restore',
                        'withdraws.force_delete',
                        'withdraws.activity',
                        'withdraws.updateStatus'
                    ]
                ],
                [
                    'group_name' => 'Transfer',
                    'permissions' => [
                        'account_transfers.list',
                        'account_transfers.create',
                        'account_transfers.view',
                        'account_transfers.update',
                        'account_transfers.delete',
                        'account_transfers.trashed',
                        'account_transfers.restore',
                        'account_transfers.force_delete',
                        'account_transfers.activity',
                        'account_transfers.updateStatus'
                    ]
                ],
                [
                    'group_name' => 'ProductionHouse',
                    'permissions' => [
                        'houses.list',
                        'houses.create',
                        'houses.view',
                        'houses.update',
                        'houses.delete',
                        'houses.trashed',
                        'houses.restore',
                        'houses.force_delete',
                        'houses.activity',
                    ]
                ],
                [
                    'group_name' => 'Production',
                    'permissions' => [
                        'productions.list',
                        'productions.create',
                        'productions.view',
                        'productions.update',
                        'productions.delete',
                        'productions.trashed',
                        'productions.restore',
                        'productions.force_delete',
                        'productions.activity',
                        'productions.updateStatus'
                    ]
                ],
                [
                    'group_name' => 'Sell',
                    'permissions' => [
                        'sells.list',
                        'sells.create',
                        'sells.view',
                        'sells.update',
                        'sells.delete',
                        'sells.trashed',
                        'sells.restore',
                        'sells.force_delete',
                        'sells.activity',
                        'sells.updateStatus'
                    ]
                ],
                [
                    'group_name' => 'ProductStock',
                    'permissions' => [
                        'productStocks.list',
                        'productStocks.view',
                        'productStocks.activity'
                    ]
                ],
                [
                    'group_name' => 'Currency',
                    'permissions' => [
                        'currencies.list',
                        'currencies.create',
                        'currencies.view',
                        'currencies.update',
                        'currencies.delete',
                        'currencies.trashed',
                        'currencies.restore',
                        'currencies.force_delete',
                        'currencies.activity'
                    ]
                ],
                [
                    'group_name' => 'SellPrice',
                    'permissions' => [
                        'sellPrices.list',
                        'sellPrices.create',
                        'sellPrices.view',
                        'sellPrices.update',
                        'sellPrices.delete',
                        'sellPrices.trashed',
                        'sellPrices.restore',
                        'sellPrices.force_delete',
                        'sellPrices.activity'
                    ]
                ],
                [
                    'group_name' => 'Report',
                    'permissions' => [
                        'rawMaterialStockReports.list',
                        'rawMaterialStockReports.view',
                        'productStockReports.list',
                        'productStockReports.view',
                        'sellReports.list',
                        'sellReports.view',
                        'assetReports.list',
                        'assetReports.view',
                        'expenseReports.list',
                        'expenseReports.view',
                        'rawMaterialPurchaseReports.list',
                        'rawMaterialPurchaseReports.view',
                        'balanceSheets.list',
                        'balanceSheets.view',
                        'depositBalance.list',
                        'depositBalance.view',
                        'withdrawBalance.list',
                        'withdrawBalance.view',
                        'transferBalance.list',
                        'transferBalance.view',
                        'sellProfitLoss.list',
                        'sellProfitLoss.view',
                        'productTransferReports.list',
                        'productTransferReports.view',
                        'rawMaterialTransferReports.list',
                        'rawMaterialTransferReports.view',
                    ]
                ],
                [
                    'group_name' => 'ProductStockTransfer',
                    'permissions' => [
                        'productStockTransfers.list',
                        'productStockTransfers.create',
                        'productStockTransfers.view',
                        'productStockTransfers.update',
                        'productStockTransfers.delete',
                        'productStockTransfers.trashed',
                        'productStockTransfers.restore',
                        'productStockTransfers.force_delete',
                        'productStockTransfers.activity'
                    ]
                ],
                [
                    'group_name' => 'RawMaterialStockTransfer',
                    'permissions' => [
                        'rawMaterialStockTransfers.list',
                        'rawMaterialStockTransfers.create',
                        'rawMaterialStockTransfers.view',
                        'rawMaterialStockTransfers.update',
                        'rawMaterialStockTransfers.delete',
                        'rawMaterialStockTransfers.trashed',
                        'rawMaterialStockTransfers.restore',
                        'rawMaterialStockTransfers.force_delete',
                        'rawMaterialStockTransfers.activity'
                    ]
                ],
                [
                    'group_name' => 'CustomerPayment',
                    'permissions' => [
                        'customerPayments.list',
                        'customerPayments.create',
                        'customerPayments.view',
                        'customerPayments.update',
                        'customerPayments.delete',
                        'customerPayments.trashed',
                        'customerPayments.restore',
                        'customerPayments.force_delete',
                        'customerPayments.activity',
                        'customerPayments.updateStatus'
                    ]
                ],
                [
                    'group_name' => 'SupplierPayment',
                    'permissions' => [
                        'supplierPayments.list',
                        'supplierPayments.create',
                        'supplierPayments.view',
                        'supplierPayments.update',
                        'supplierPayments.delete',
                        'supplierPayments.trashed',
                        'supplierPayments.restore',
                        'supplierPayments.force_delete',
                        'supplierPayments.activity',
                        'supplierPayments.updateStatus'
                    ]
                ],
                [
                    'group_name' => 'CustomerRefund',
                    'permissions' => [
                        'customerRefunds.list',
                        'customerRefunds.create',
                        'customerRefunds.view',
                        'customerRefunds.update',
                        'customerRefunds.delete',
                        'customerRefunds.trashed',
                        'customerRefunds.restore',
                        'customerRefunds.force_delete',
                        'customerRefunds.activity',
                        'customerRefunds.updateStatus'
                    ]
                ],
                [
                    'group_name' => 'SupplierRefund',
                    'permissions' => [
                        'supplierRefunds.list',
                        'supplierRefunds.create',
                        'supplierRefunds.view',
                        'supplierRefunds.update',
                        'supplierRefunds.delete',
                        'supplierRefunds.trashed',
                        'supplierRefunds.restore',
                        'supplierRefunds.force_delete',
                        'supplierRefunds.activity',
                        'supplierRefunds.updateStatus'
                    ]
                ],
                [
                    'group_name' => 'ProductionPayment',
                    'permissions' => [
                        'productionPayments.list',
                        'productionPayments.create',
                        'productionPayments.view',
                        'productionPayments.update',
                        'productionPayments.delete',
                        'productionPayments.trashed',
                        'productionPayments.restore',
                        'productionPayments.force_delete',
                        'productionPayments.activity',
                        'productionPayments.updateStatus'
                    ]
                ],
                [
                    'group_name' => 'Global',
                    'permissions' => [
                        'dashboard_manage',
                        'site_setting_manage',
                        'global_setting_manage',
                        'inventory_manage',
                    ]
                ],
        ];

        for ($i=0 ; $i < count($permissions) ; $i++) {
            $permission_group = $permissions[$i]['group_name'];
            for ($j=0 ; $j < count($permissions[$i]['permissions']) ; $j++) {
               $super_permission = Permission::where('name', $permissions[$i]['permissions'][$j])->first();
               if (!$super_permission) {
                   $super_permission = Permission::create(['name' => $permissions[$i]['permissions'][$j],'group_name' => $permission_group]);
               }
               $superAdmin->givePermissionTo($super_permission);
               $super_permission->assignRole($superAdmin);
            }
        }
    }
}
