<?php

use App\Http\Controllers\Admin\SellController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('admin.dashboard'));
})->middleware('admin');

Route::post('/sells/set-currency', [SellController::class, 'setCurrency'])
    ->name('sells.setCurrency')
    ->middleware('admin');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
require __DIR__.'/command.php';
