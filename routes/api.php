<?php

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

Route::name('api.')->group(function () {
    Route::prefix('/users')->name('users.')->group(function () {
        Route::prefix('/login')->name('login.')->group(function () {
            Route::post('/', \App\Http\Controllers\Api\Users\Login\StoreController::class)->name('store');
        });
        Route::post('/', \App\Http\Controllers\Api\Users\StoreController::class)->name('store');
    });
});
