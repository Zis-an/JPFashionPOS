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
                        'rawMaterialStocks.create',
                        'rawMaterialStocks.view',
                        'rawMaterialStocks.update',
                        'rawMaterialStocks.delete',
                        'rawMaterialStocks.trashed',
                        'rawMaterialStocks.restore',
                        'rawMaterialStocks.force_delete',
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
