<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


Route::prefix('command')->middleware( ['admin','web'])->group(function (){

    Route::get('/clear-cache', function (){
        Artisan::call('cache:clear');
        return redirect()->back()->with('info', 'Notification Cache Cleared');
    });
    Route::get('/clear-config', function (){
        Artisan::call('config:clear');
        return redirect()->back()->with('info', 'Notification Config Cleared');
    });
    Route::get('/clear-route', function (){
        Artisan::call('route:clear');
        return redirect()->back()->with('info', 'Notification Route Cleared');
    });
    Route::get('/optimize', function (){
        Artisan::call('optimize:clear');
        return redirect()->back()->with('info', 'Notification Optimize Cleared');
    });
    Route::get('/migrate', function (){
        Artisan::call('migrate');
        return redirect()->back()->with('info', 'Notification Migrated Cleared');
    });
    Route::get('/migrate-fresh', function (){
        Artisan::call('migrate:fresh');
        return redirect()->back()->with('info', 'Notification Migrated Fresh Cleared');
    });
    Route::get('/migrate-fresh-seed', function (){
        Artisan::call('migrate:fresh --seed');
        return redirect()->back()->with('info', 'Notification Migrated Fresh Fresh Cleared');
    });
    Route::get('/seed', function (){
        $seeder = new \Database\Seeders\RoleSeeder();
        $seeder->run();
        return redirect()->route('admin.dashboard')->with('info', 'Notification Seed Cleared');
    });

});
