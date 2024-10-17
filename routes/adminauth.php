<?php

use Illuminate\Support\Facades\Route;

Route::get('/register',[\App\Http\Controllers\Admin\Auth\RegisterController::class,'showRegistrationForm'])->name('register');
Route::post('/register',[\App\Http\Controllers\Admin\Auth\RegisterController::class,'register']);

Route::get('/login',[\App\Http\Controllers\Admin\Auth\LoginController::class,'showLoginForm'])->name('login');
Route::post('/login',[\App\Http\Controllers\Admin\Auth\LoginController::class,'login']);
Route::post('/logout',[\App\Http\Controllers\Admin\Auth\LoginController::class,'logout'])->name('logout');

Route::get('/password/confirm',[\App\Http\Controllers\Admin\Auth\ConfirmPasswordController::class,'showConfirmForm'])->name('password.confirm');
Route::post('/password/confirm',[\App\Http\Controllers\Admin\Auth\ConfirmPasswordController::class,'confirm']);
Route::post('/password/email',[\App\Http\Controllers\Admin\Auth\ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset',[\App\Http\Controllers\Admin\Auth\ForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');
Route::post('/password/reset',[\App\Http\Controllers\Admin\Auth\ResetPasswordController::class,'reset'])->name('password.update');
Route::get('/password/reset/{token}',[\App\Http\Controllers\Admin\Auth\ResetPasswordController::class,'showResetForm'])->name('password.reset');
