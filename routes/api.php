<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\Admin\ProductSellPriceController;
use App\Http\Controllers\Admin\ProductStockTransferController;
use App\Http\Controllers\Admin\RawMaterialController;
use App\Http\Controllers\Admin\RawMaterialStockTransferController;
use App\Http\Controllers\Admin\SellController;
use App\Http\Controllers\Admin\ShowroomTransferController;
use App\Http\Controllers\Admin\WarehouseTransferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/api/materials', [RawMaterialController::class, 'getAllMaterials'])
    ->middleware(['web','admin','permission:materials.list'])
    ->name('materials.all');

Route::get('/raw-materials/by-warehouse', [ProductionController::class, 'getRawMaterialsByWarehouse'])
    ->name('raw-materials.by-warehouse');

Route::get('/products/all', [ProductController::class, 'getAllProducts'])
    ->name('products.all');

Route::get('/get-products-by-category', [SellController::class, 'getProductsByCategory'])
    ->name('products.by-category');

Route::get('/get-all-products', [SellController::class, 'getAllProducts']);


Route::get('/product-stocks/{stock}/get-sell-price-data', [ProductSellPriceController::class, 'getSellPriceData']);
Route::post('/product-stocks/{stock}/update-sell-price', [ProductSellPriceController::class, 'updateSellPrice']);

Route::get('/product-stocks/{showroom_id}', [ProductStockTransferController::class, 'getProductStocksByShowroom']);
Route::get('/raw-material-stocks/{warehouse_id}', [RawMaterialStockTransferController::class, 'getRawMaterialStocksByWarehouse']);
