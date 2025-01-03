<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AccountTransferController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AssetCategoryController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomerPaymentController;
use App\Http\Controllers\Admin\CustomerRefundController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DepositController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\GlobalSettingController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\Admin\ProductionHouseController;
use App\Http\Controllers\Admin\ProductionPaymentController;
use App\Http\Controllers\Admin\ProductStockController;
use App\Http\Controllers\Admin\ProductStockTransferController;
use App\Http\Controllers\Admin\RawMaterialCategoryController;
use App\Http\Controllers\Admin\RawMaterialController;
use App\Http\Controllers\Admin\RawMaterialPurchaseController;
use App\Http\Controllers\Admin\RawMaterialStockController;
use App\Http\Controllers\Admin\RawMaterialStockTransferController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SellController;
use App\Http\Controllers\Admin\ShowroomController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\SupplierPaymentController;
use App\Http\Controllers\Admin\SupplierRefundController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\WithdrawController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('/roles',RoleController::class)->middleware('permission:roles.list');
Route::resource('/permissions',PermissionController::class)->middleware('permission:permissions.list');

// Admin
Route::get('/admins/trashed',[AdminController::class,'trashed_list'])
    ->middleware('permission:admins.trashed')
    ->name('admins.trashed');
Route::get('/admins/trashed/{admin}/restore',[AdminController::class,'restore'])
    ->middleware('permission:admins.restore')
    ->name('admins.restore');
Route::get('/admins/trashed/{admin}/delete',[AdminController::class,'force_delete'])
    ->middleware('permission:admins.force_delete')
    ->name('admins.force_delete');
Route::resource('/admins',AdminController::class)->middleware('permission:admins.list');

// Accounts
Route::get('/accounts/trashed', [AccountController::class, 'trashed_list'])
    ->middleware('permission:accounts.trashed')
    ->name('accounts.trashed');
Route::get('/accounts/trashed/{account}/restore', [AccountController::class, 'restore'])
    ->middleware('permission:accounts.restore')
    ->name('accounts.restore');
Route::get('/accounts/trashed/{account}/delete', [AccountController::class, 'force_delete'])
    ->middleware('permission:accounts.force_delete')
    ->name('accounts.force_delete');
Route::resource('/accounts', AccountController::class)->middleware('permission:accounts.list');

// ExpenseCategory
Route::get('/expense-categories/trashed', [ExpenseCategoryController::class, 'trashed_list'])
    ->middleware('permission:expense-categories.trashed')
    ->name('expense-categories.trashed');
Route::get('/expense-categories/trashed/{expense_category}/restore', [ExpenseCategoryController::class, 'restore'])
    ->middleware('permission:expense-categories.restore')
    ->name('expense-categories.restore');
Route::get('/expense-categories/trashed/{expense_category}/delete', [ExpenseCategoryController::class, 'force_delete'])
    ->middleware('permission:expense-categories.force_delete')
    ->name('expense-categories.force_delete');
Route::resource('/expense-categories', ExpenseCategoryController::class)->middleware('permission:expense-categories.list');

// Expense
Route::get('/expenses/trashed', [ExpenseController::class, 'trashed_list'])
    ->middleware('permission:expenses.trashed')
    ->name('expenses.trashed');
Route::get('/expenses/trashed/{expense}/restore', [ExpenseController::class, 'restore'])
    ->middleware('permission:expenses.restore')
    ->name('expenses.restore');
Route::get('/expenses/trashed/{expense}/delete', [ExpenseController::class, 'force_delete'])
    ->middleware('permission:expenses.force_delete')
    ->name('expenses.force_delete');
Route::get('/expenses/{expense}/status/{status}',[ExpenseController::class, 'updateStatus'])
    ->middleware('permission:expenses.updateStatus')
    ->name('expenses.updateStatus');
Route::post('/expenses/delete-photo', [ExpenseController::class, 'deletePhoto'])->name('expenses.deletePhoto');
Route::resource('/expenses', ExpenseController::class)->middleware('permission:expenses.list');


// AssetCategory
Route::get('/asset-categories/trashed', [AssetCategoryController::class, 'trashed_list'])
    ->middleware('permission:asset-categories.trashed')
    ->name('asset-categories.trashed');
Route::get('/asset-categories/trashed/{asset_category}/restore', [AssetCategoryController::class, 'restore'])
    ->middleware('permission:asset-categories.restore')
    ->name('asset-categories.restore');
Route::get('/asset-categories/trashed/{asset_category}/delete', [AssetCategoryController::class, 'force_delete'])
    ->middleware('permission:asset-categories.force_delete')
    ->name('asset-categories.force_delete');
Route::resource('/asset-categories', AssetCategoryController::class)->middleware('permission:asset-categories.list');

// Assets
Route::get('/assets/trashed', [AssetController::class, 'trashed_list'])
    ->middleware('permission:assets.trashed')
    ->name('assets.trashed');
Route::get('/assets/trashed/{asset}/restore', [AssetController::class, 'restore'])
    ->middleware('permission:assets.restore')
    ->name('assets.restore');
Route::get('/assets/trashed/{asset}/delete', [AssetController::class, 'force_delete'])
    ->middleware('permission:assets.force_delete')
    ->name('assets.force_delete');
Route::get('/assets/{asset}/status/{status}',[AssetController::class, 'updateStatus'])
    ->name('assets.updateStatus')->middleware('permission:assets.updateStatus');
Route::resource('/assets', AssetController::class)->middleware('permission:assets.list');

// Units
Route::get('/units/trashed', [UnitController::class, 'trashed_list'])
    ->middleware('permission:units.trashed')
    ->name('units.trashed');
Route::get('/units/trashed/{unit}/restore', [UnitController::class, 'restore'])
    ->middleware('permission:units.restore')
    ->name('units.restore');
Route::get('/units/trashed/{unit}/delete', [UnitController::class, 'force_delete'])
    ->middleware('permission:units.force_delete')
    ->name('units.force_delete');
Route::resource('/units', UnitController::class)->middleware('permission:units.list');

// Colors
Route::get('/colors/trashed', [ColorController::class, 'trashed_list'])
    ->middleware('permission:colors.trashed')
    ->name('colors.trashed');
Route::get('/colors/trashed/{color}/restore', [ColorController::class, 'restore'])
    ->middleware('permission:colors.restore')
    ->name('colors.restore');
Route::get('/colors/trashed/{color}/delete', [ColorController::class, 'force_delete'])
    ->middleware('permission:colors.force_delete')
    ->name('colors.force_delete');
Route::resource('/colors', ColorController::class)->middleware('permission:colors.list');

// Brands
Route::get('/brands/trashed', [BrandController::class, 'trashed_list'])
    ->middleware('permission:brands.trashed')
    ->name('brands.trashed');
Route::get('/brands/trashed/{brand}/restore', [BrandController::class, 'restore'])
    ->middleware('permission:brands.restore')
    ->name('brands.restore');
Route::get('/brands/trashed/{brand}/delete', [BrandController::class, 'force_delete'])
    ->middleware('permission:brands.force_delete')
    ->name('brands.force_delete');
Route::resource('/brands', BrandController::class)->middleware('permission:brands.list');

// Sizes
Route::get('/sizes/trashed', [SizeController::class, 'trashed_list'])
    ->middleware('permission:sizes.trashed')
    ->name('sizes.trashed');
Route::get('/sizes/trashed/{size}/restore', [SizeController::class, 'restore'])
    ->middleware('permission:sizes.restore')
    ->name('sizes.restore');
Route::get('/sizes/trashed/{size}/delete', [SizeController::class, 'force_delete'])
    ->middleware('permission:sizes.force_delete')
    ->name('sizes.force_delete');
Route::resource('/sizes', SizeController::class)->middleware('permission:sizes.list');

// Customers
Route::get('/customers/trashed', [CustomerController::class, 'trashed_list'])
    ->middleware('permission:customers.trashed')
    ->name('customers.trashed');
Route::get('/customers/trashed/{customer}/restore', [CustomerController::class, 'restore'])
    ->middleware('permission:customers.restore')
    ->name('customers.restore');
Route::get('/customers/trashed/{customer}/delete', [CustomerController::class, 'force_delete'])
    ->middleware('permission:customers.force_delete')
    ->name('customers.force_delete');
Route::resource('/customers', CustomerController::class)->middleware('permission:customers.list');

// Suppliers
Route::get('/suppliers/trashed', [SupplierController::class, 'trashed_list'])
    ->middleware('permission:suppliers.trashed')
    ->name('suppliers.trashed');
Route::get('/suppliers/trashed/{supplier}/restore', [SupplierController::class, 'restore'])
    ->middleware('permission:suppliers.restore')
    ->name('suppliers.restore');
Route::get('/suppliers/trashed/{supplier}/delete', [SupplierController::class, 'force_delete'])
    ->middleware('permission:suppliers.force_delete')
    ->name('suppliers.force_delete');
Route::resource('/suppliers', SupplierController::class)->middleware('permission:suppliers.list');

// Payment Methods
Route::get('/paymentMethods/trashed', [PaymentMethodController::class, 'trashed_list'])
    ->middleware('permission:paymentMethods.trashed')
    ->name('paymentMethods.trashed');
Route::get('/paymentMethods/trashed/{paymentMethod}/restore', [PaymentMethodController::class, 'restore'])
    ->middleware('permission:paymentMethods.restore')
    ->name('paymentMethods.restore');
Route::get('/paymentMethods/trashed/{paymentMethod}/delete', [PaymentMethodController::class, 'force_delete'])
    ->middleware('permission:paymentMethods.force_delete')
    ->name('paymentMethods.force_delete');
Route::resource('/paymentMethods', PaymentMethodController::class)->middleware('permission:paymentMethods.list');

// Warehouses
Route::get('/warehouses/trashed', [WarehouseController::class, 'trashed_list'])
    ->middleware('permission:warehouses.trashed')
    ->name('warehouses.trashed');
Route::get('/warehouses/trashed/{warehouse}/restore', [WarehouseController::class, 'restore'])
    ->middleware('permission:warehouses.restore')
    ->name('warehouses.restore');
Route::get('/warehouses/trashed/{warehouse}/delete', [WarehouseController::class, 'force_delete'])
    ->middleware('permission:warehouses.force_delete')
    ->name('warehouses.force_delete');
Route::resource('/warehouses', WarehouseController::class)
    ->middleware('permission:warehouses.list');

// Raw Material Categories
Route::get('/materialCategories/trashed', [RawMaterialCategoryController::class, 'trashed_list'])
    ->middleware('permission:materialCategories.trashed')
    ->name('materialCategories.trashed');
Route::get('/materialCategories/trashed/{materialCategory}/restore', [RawMaterialCategoryController::class, 'restore'])
    ->middleware('permission:materialCategories.restore')
    ->name('materialCategories.restore');
Route::get('/materialCategories/trashed/{materialCategory}/delete', [RawMaterialCategoryController::class, 'force_delete'])
    ->middleware('permission:materialCategories.force_delete')
    ->name('materialCategories.force_delete');
Route::resource('/materialCategories', RawMaterialCategoryController::class)
    ->middleware('permission:materialCategories.list');

// Raw Materials
Route::get('/materials/trashed', [RawMaterialController::class, 'trashed_list'])
    ->middleware('permission:materials.trashed')
    ->name('materials.trashed');
Route::get('/materials/trashed/{material}/restore', [RawMaterialController::class, 'restore'])
    ->middleware('permission:materials.restore')
    ->name('materials.restore');
Route::get('/materials/trashed/{material}/delete', [RawMaterialController::class, 'force_delete'])
    ->middleware('permission:materials.force_delete')
    ->name('materials.force_delete');
Route::resource('/materials', RawMaterialController::class)
    ->middleware('permission:materials.list');


// RawMaterialPurchase
Route::get('/raw-material-purchases/trashed', [RawMaterialPurchaseController::class, 'trashed_list'])
    ->middleware('permission:rawMaterialPurchases.trashed')
    ->name('raw-material-purchases.trashed');
Route::get('/raw-material-purchases/trashed/{raw_material_purchase}/restore', [RawMaterialPurchaseController::class, 'restore'])
    ->middleware('permission:rawMaterialPurchases.restore')
    ->name('raw-material-purchases.restore');
Route::get('/raw-material-purchases/trashed/{raw_material_purchase}/delete', [RawMaterialPurchaseController::class, 'force_delete'])
    ->middleware('permission:rawMaterialPurchases.force_delete')
    ->name('raw-material-purchases.force_delete');
Route::get('/raw-material-purchases/{raw_material_purchase}/status/{status}',
    [RawMaterialPurchaseController::class, 'updateStatus'])
    ->name('raw-material-purchases.updateStatus');
Route::get('/raw-material-purchases/{raw_material_purchase}/print',
    [RawMaterialPurchaseController::class, 'printRawMaterialPurchase'])
    ->name('raw-material-purchases.print');
Route::resource('/raw-material-purchases', RawMaterialPurchaseController::class)
    ->middleware('permission:rawMaterialPurchases.list');

// Showroom
Route::get('/showrooms/trashed', [ShowroomController::class, 'trashed_list'])
    ->middleware('permission:showrooms.trashed')
    ->name('showrooms.trashed');
Route::get('/showrooms/trashed/{showroom}/restore', [ShowroomController::class, 'restore'])
    ->middleware('permission:showrooms.restore')
    ->name('showrooms.restore');
Route::get('/showrooms/trashed/{showroom}/delete', [ShowroomController::class, 'force_delete'])
    ->middleware('permission:showrooms.force_delete')
    ->name('showrooms.force_delete');
Route::resource('/showrooms', ShowroomController::class)
    ->middleware('permission:showrooms.list');

// Employee
Route::get('/employees/trashed', [EmployeeController::class, 'trashed_list'])
    ->middleware('permission:employees.trashed')
    ->name('employees.trashed');
Route::get('/employees/trashed/{employee}/restore', [EmployeeController::class, 'restore'])
    ->middleware('permission:employees.restore')
    ->name('employees.restore');
Route::get('/employees/trashed/{employee}/delete', [EmployeeController::class, 'force_delete'])
    ->middleware('permission:employees.force_delete')
    ->name('employees.force_delete');
Route::delete('/employees/{employee}/delete_certificate/{key}', [EmployeeController::class, 'delete_certificate'])
    ->name('employees.delete_certificate');
Route::resource('/employees', EmployeeController::class)
    ->middleware('permission:employees.list');

// Department
Route::get('/departments/trashed', [DepartmentController::class, 'trashed_list'])
    ->middleware('permission:departments.trashed')
    ->name('departments.trashed');
Route::get('/departments/trashed/{department}/restore', [DepartmentController::class, 'restore'])
    ->middleware('permission:departments.restore')
    ->name('departments.restore');
Route::get('/departments/trashed/{department}/delete', [DepartmentController::class, 'force_delete'])
    ->middleware('permission:departments.force_delete')
    ->name('departments.force_delete');
Route::resource('/departments', DepartmentController::class)->middleware('permission:departments.list');

// Product Category
Route::get('/productCategories/trashed', [ProductCategoryController::class, 'trashed_list'])
    ->middleware('permission:productCategories.trashed')
    ->name('productCategories.trashed');
Route::get('/productCategories/trashed/{productCategory}/restore', [ProductCategoryController::class, 'restore'])
    ->middleware('permission:productCategories.restore')
    ->name('productCategories.restore');
Route::get('/productCategories/trashed/{productCategory}/delete', [ProductCategoryController::class, 'force_delete'])
    ->middleware('permission:productCategories.force_delete')
    ->name('productCategories.force_delete');
Route::resource('/productCategories', ProductCategoryController::class)->middleware('permission:productCategories.list');

// Product
Route::get('/products/trashed', [ProductController::class, 'trashed_list'])
    ->middleware('permission:products.trashed')
    ->name('products.trashed');
Route::get('/products/trashed/{product}/restore', [ProductController::class, 'restore'])
    ->middleware('permission:products.restore')
    ->name('products.restore');
Route::get('/products/trashed/{product}/delete', [ProductController::class, 'force_delete'])
    ->middleware('permission:products.force_delete')
    ->name('products.force_delete');
Route::delete('/products/{product}/image/{key}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
Route::delete('/products/{product}/thumbnail', [ProductController::class, 'deleteThumb'])->name('products.deleteThumb');
Route::resource('/products', ProductController::class)->middleware('permission:products.list');


// Raw Material Stock
Route::resource('/raw-material-stocks', RawMaterialStockController::class)
    ->middleware('permission:rawMaterialStocks.list');

// Deposit
Route::get('/deposits/trashed', [DepositController::class, 'trashed_list'])
    ->middleware('permission:deposits.trashed')
    ->name('deposits.trashed');
Route::get('/deposits/trashed/{deposit}/restore', [DepositController::class, 'restore'])
    ->middleware('permission:deposits.restore')
    ->name('deposits.restore');
Route::get('/deposits/trashed/{deposit}/delete', [DepositController::class, 'force_delete'])
    ->middleware('permission:deposits.force_delete')
    ->name('deposits.force_delete');
Route::get('/deposits/{deposit}/status/{status}',[DepositController::class, 'updateStatus'])
    ->name('deposits.updateStatus')
    ->middleware('permission:deposits.updateStatus');
Route::resource('/deposits', DepositController::class)->middleware('permission:deposits.list');

// Withdraw
Route::get('/withdraws/trashed', [WithdrawController::class, 'trashed_list'])
    ->middleware('permission:withdraws.trashed')
    ->name('withdraws.trashed');
Route::get('/withdraws/trashed/{withdraw}/restore', [WithdrawController::class, 'restore'])
    ->middleware('permission:withdraws.restore')
    ->name('withdraws.restore');
Route::get('/withdraws/trashed/{withdraw}/delete', [WithdrawController::class, 'force_delete'])
    ->middleware('permission:withdraws.force_delete')
    ->name('withdraws.force_delete');
Route::get('/withdraws/{withdraw}/status/{status}',[WithdrawController::class, 'updateStatus'])
    ->name('withdraws.updateStatus')
    ->middleware('permission:withdraws.updateStatus');
Route::resource('/withdraws', WithdrawController::class)->middleware('permission:withdraws.list');

// Transfer
Route::get('/account-transfers/trashed', [AccountTransferController::class, 'trashed_list'])
    ->middleware('permission:account_transfers.trashed')
    ->name('account-transfers.trashed');
Route::get('/account-transfers/trashed/{account_transfer}/restore', [AccountTransferController::class, 'restore'])
    ->middleware('permission:account_transfers.restore')
    ->name('account-transfers.restore');
Route::get('/account-transfers/trashed/{account_transfer}/delete', [AccountTransferController::class, 'force_delete'])
    ->middleware('permission:account_transfers.force_delete')
    ->name('account-transfers.force_delete');
Route::get('/account-transfers/{account_transfer}/status/{status}',[AccountTransferController::class, 'updateStatus'])
    ->name('account-transfers.updateStatus')
    ->middleware('permission:account_transfers.updateStatus');
Route::resource('/account-transfers', AccountTransferController::class)->middleware('permission:account_transfers.list');

// Production House
Route::get('/houses/trashed', [ProductionHouseController::class, 'trashed_list'])
    ->middleware('permission:houses.trashed')
    ->name('houses.trashed');
Route::get('/houses/trashed/{house}/restore', [ProductionHouseController::class, 'restore'])
    ->middleware('permission:houses.restore')
    ->name('houses.restore');
Route::get('/houses/trashed/{house}/delete', [ProductionHouseController::class, 'force_delete'])
    ->middleware('permission:houses.force_delete')
    ->name('houses.force_delete');
Route::resource('/houses', ProductionHouseController::class)
    ->middleware('permission:houses.list');

// Production
Route::get('/productions/trashed', [ProductionController::class, 'trashed_list'])
    ->middleware('permission:productions.trashed')
    ->name('productions.trashed');
Route::get('/productions/trashed/{production}/restore', [ProductionController::class, 'restore'])
    ->middleware('permission:productions.restore')
    ->name('productions.restore');
Route::get('/productions/trashed/{production}/delete', [ProductionController::class, 'force_delete'])
    ->middleware('permission:productions.force_delete')
    ->name('productions.force_delete');
Route::get('/productions/{production}/status/{status}',[ProductionController::class, 'updateStatus'])
    ->name('productions.updateStatus')
    ->middleware('permission:productions.updateStatus');
Route::get('/productions/{production}/print',[ProductionController::class, 'printProduction'])
    ->name('productions.print');
Route::resource('/productions', ProductionController::class)
    ->middleware('permission:productions.list');

// Sell
Route::get('/sells/trashed', [SellController::class, 'trashed_list'])
    ->middleware('permission:sells.trashed')
    ->name('sells.trashed');
Route::get('/sells/trashed/{sell}/restore', [SellController::class, 'restore'])
    ->middleware('permission:sells.restore')
    ->name('sells.restore');
Route::get('/sells/trashed/{sell}/delete', [SellController::class, 'force_delete'])
    ->middleware('permission:sells.force_delete')
    ->name('sells.force_delete');
Route::get('/sells/{sell}/status/{status}',[SellController::class, 'updateStatus'])
    ->name('sells.updateStatus')
    ->middleware('permission:sells.updateStatus');
Route::get('/sells/{id}/invoice', [SellController::class, 'showInvoice'])->name('sells.invoiceTemplate');
Route::resource('/sells', SellController::class)
    ->middleware('permission:sells.list');

// Product Stock
Route::resource('/product-stocks', ProductStockController::class)
    ->middleware('permission:productStocks.list');

// Currency
Route::get('/currencies/trashed', [CurrencyController::class, 'trashed_list'])
    ->middleware('permission:currencies.trashed')
    ->name('currencies.trashed');
Route::get('/currencies/trashed/{currency}/restore', [CurrencyController::class, 'restore'])
    ->middleware('permission:currencies.restore')
    ->name('currencies.restore');
Route::get('/currencies/trashed/{currency}/delete', [CurrencyController::class, 'force_delete'])
    ->middleware('permission:currencies.force_delete')
    ->name('currencies.force_delete');
Route::resource('/currencies', CurrencyController::class)
    ->middleware('permission:currencies.list');

// ShowroomTransfer
Route::get('/product-stock-transfers/trashed', [ProductStockTransferController::class, 'trashed_list'])
    ->middleware('permission:productStockTransfers.trashed')
    ->name('product-stock-transfers.trashed');
Route::get('/product-stock-transfers/trashed/{product_stock_transfer}/restore', [ProductStockTransferController::class, 'restore'])
    ->middleware('permission:productStockTransfers.restore')
    ->name('product-stock-transfers.restore');
Route::get('/product-stock-transfers/trashed/{product_stock_transfer}/delete', [ProductStockTransferController::class, 'force_delete'])
    ->middleware('permission:productStockTransfers.force_delete')
    ->name('product-stock-transfers.force_delete');
Route::get('/product-stock-transfers/{product_stock_transfer}/status',[ProductStockTransferController::class, 'changeStatus'])
    ->name('product-stock-transfers.changeStatus');
Route::resource('/product-stock-transfers', ProductStockTransferController::class)
    ->middleware('permission:productStockTransfers.list');

// WarehouseTransfer
Route::get('/raw-material-stock-transfers/trashed', [RawMaterialStockTransferController::class, 'trashed_list'])
    ->middleware('permission:rawMaterialStockTransfers.trashed')
    ->name('raw-material-stock-transfers.trashed');
Route::get('/raw-material-stock-transfers/trashed/{raw_material_stock_transfer}/restore', [RawMaterialStockTransferController::class, 'restore'])
    ->middleware('permission:rawMaterialStockTransfers.restore')
    ->name('raw-material-stock-transfers.restore');
Route::get('/raw-material-stock-transfers/trashed/{raw_material_stock_transfer}/delete', [RawMaterialStockTransferController::class, 'force_delete'])
    ->middleware('permission:rawMaterialStockTransfers.force_delete')
    ->name('raw-material-stock-transfers.force_delete');
Route::get('/raw-material-stock-transfers/{raw_material_stock_transfer}/status',[RawMaterialStockTransferController::class, 'changeStatus'])
    ->name('raw-material-stock-transfers.changeStatus');

Route::resource('/raw-material-stock-transfers', RawMaterialStockTransferController::class)
    ->middleware('permission:rawMaterialStockTransfers.list');

// Reports
Route::get('/raw-material-stock-reports', [ReportController::class, 'rawMaterialStockReports'])
    ->name('rawMaterialStockReports');
Route::get('/product-stock-reports', [ReportController::class, 'productStockReports'])
    ->name('productStockReports');
Route::get('/sell-reports', [ReportController::class, 'sellReports'])
    ->name('sellReports');
Route::get('/asset-reports', [ReportController::class, 'assetReports'])
    ->name('assetReports');
Route::get('/expense-reports', [ReportController::class, 'expenseReports'])
    ->name('expenseReports');
Route::get('/raw-material-purchase-reports', [ReportController::class, 'rawMaterialPurchaseReports'])
    ->name('rawMaterialPurchaseReports');
Route::get('/product-transfer-reports', [ReportController::class, 'productTransferReports'])
    ->name('productTransferReports');
Route::get('/raw-material-transfer-reports', [ReportController::class, 'rawMaterialTransferReports'])
    ->name('rawMaterialTransferReports');
Route::get('/account-balance-sheets', [ReportController::class, 'balanceSheetReports'])
    ->name('balanceSheetReports');
Route::get('/deposit-balance-sheets', [ReportController::class, 'depositBalanceSheet'])
    ->name('depositBalanceSheets');
Route::get('/withdraw-balance-sheets', [ReportController::class, 'withdrawBalanceSheet'])
    ->name('withdrawBalanceSheets');
Route::get('/transfer-balance-sheets', [ReportController::class, 'transferBalanceSheet'])
    ->name('transferBalanceSheets');
Route::get('/sell-profit-loss', [ReportController::class, 'sellProfitLoss'])
    ->name('sellProfitLoss');
Route::get('/cron-job-logs', [ReportController::class, 'cronJobLogs'])
    ->name('cronJobLogs');

// Settings
Route::get('global-setting',[GlobalSettingController::class,'global_setting'])->name('global_setting');
Route::post('update-global-setting',[GlobalSettingController::class,'update_global_setting'])->name('update_global_setting');

// CustomerPayments
Route::get('/customer-payments/trashed', [CustomerPaymentController::class, 'trashed_list'])
    ->middleware('permission:customerPayments.trashed')
    ->name('customer-payments.trashed');
Route::get('/customer-payments/trashed/{customer_payment}/restore', [CustomerPaymentController::class, 'restore'])
    ->middleware('permission:customerPayments.restore')
    ->name('customer-payments.restore');
Route::get('/customer-payments/trashed/{customer_payment}/delete', [CustomerPaymentController::class, 'force_delete'])
    ->middleware('permission:customerPayments.force_delete')
    ->name('customer-payments.force_delete');
Route::get('/customer-payments/{customer_payment}/status/{status}',[CustomerPaymentController::class, 'updateStatus'])
    ->name('customer-payments.updateStatus')
    ->middleware('permission:customerPayments.updateStatus');
Route::resource('/customer-payments', CustomerPaymentController::class)->middleware('permission:customerPayments.list');

// SupplierPayments
Route::get('/supplier-payments/trashed', [SupplierPaymentController::class, 'trashed_list'])
    ->middleware('permission:supplierPayments.trashed')
    ->name('supplier-payments.trashed');
Route::get('/supplier-payments/trashed/{supplier_payment}/restore', [SupplierPaymentController::class, 'restore'])
    ->middleware('permission:supplierPayments.restore')
    ->name('supplier-payments.restore');
Route::get('/supplier-payments/trashed/{supplier_payment}/delete', [SupplierPaymentController::class, 'force_delete'])
    ->middleware('permission:supplierPayments.force_delete')
    ->name('supplier-payments.force_delete');
Route::get('/supplier-payments/{supplier_payment}/status/{status}',[SupplierPaymentController::class, 'updateStatus'])
    ->name('supplier-payments.updateStatus')
    ->middleware('permission:supplierPayments.updateStatus');
Route::resource('/supplier-payments', SupplierPaymentController::class)->middleware('permission:supplierPayments.list');

// ProductionPayments
Route::get('/production-payments/trashed', [ProductionPaymentController::class, 'trashed_list'])
    ->middleware('permission:productionPayments.trashed')
    ->name('production-payments.trashed');
Route::get('/production-payments/trashed/{production_payment}/restore', [ProductionPaymentController::class, 'restore'])
    ->middleware('permission:productionPayments.restore')
    ->name('production-payments.restore');
Route::get('/production-payments/trashed/{production_payment}/delete', [ProductionPaymentController::class, 'force_delete'])
    ->middleware('permission:productionPayments.force_delete')
    ->name('production-payments.force_delete');
Route::get('/production-payments/{production_payment}/status/{status}',[ProductionPaymentController::class, 'updateStatus'])
    ->name('production-payments.updateStatus')
    ->middleware('permission:productionPayments.updateStatus');
Route::resource('/production-payments', ProductionPaymentController::class)->middleware('permission:productionPayments.list');

// CustomerRefunds
Route::get('/customer-refunds/trashed', [CustomerRefundController::class, 'trashed_list'])
    ->middleware('permission:customerRefunds.trashed')
    ->name('customer-refunds.trashed');
Route::get('/customer-refunds/trashed/{customer_refund}/restore', [CustomerRefundController::class, 'restore'])
    ->middleware('permission:customerRefunds.restore')
    ->name('customer-refunds.restore');
Route::get('/customer-refunds/trashed/{customer_refund}/delete', [CustomerRefundController::class, 'force_delete'])
    ->middleware('permission:customerRefunds.force_delete')
    ->name('customer-refunds.force_delete');
Route::get('/customer-refunds/{customer_refund}/status/{status}',[CustomerRefundController::class, 'updateStatus'])
    ->name('customer-refunds.updateStatus')
    ->middleware('permission:customerRefunds.updateStatus');
Route::resource('/customer-refunds', CustomerRefundController::class)->middleware('permission:customerRefunds.list');

// SupplierRefunds
Route::get('/supplier-refunds/trashed', [SupplierRefundController::class, 'trashed_list'])
    ->middleware('permission:supplierRefunds.trashed')
    ->name('supplier-refunds.trashed');
Route::get('/supplier-refunds/trashed/{supplier_refund}/restore', [SupplierRefundController::class, 'restore'])
    ->middleware('permission:supplierRefunds.restore')
    ->name('supplier-refunds.restore');
Route::get('/supplier-refunds/trashed/{supplier_refund}/delete', [SupplierRefundController::class, 'force_delete'])
    ->middleware('permission:supplierRefunds.force_delete')
    ->name('supplier-refunds.force_delete');
Route::get('/supplier-refunds/{supplier_refund}/status/{status}',[SupplierRefundController::class, 'updateStatus'])
    ->name('supplier-refunds.updateStatus')
    ->middleware('permission:customerRefunds.updateStatus');
Route::resource('/supplier-refunds', SupplierRefundController::class)->middleware('permission:supplierRefunds.list');

// Profile
Route::get('/profile',[AdminController::class,'profile'])->name('profile');
Route::post('/profile',[AdminController::class,'profile_update'])->name('profile_update');
