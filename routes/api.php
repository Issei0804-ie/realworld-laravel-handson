<?php

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

// 認証なし
Route::name('api.')->group(function () {
    Route::prefix('/users')->name('users.')->group(function () {
        Route::prefix('/login')->name('login.')->group(function () {
            Route::post('/', \App\Http\Controllers\Api\Users\Login\StoreController::class)->name('store');
        });
        Route::post('/', \App\Http\Controllers\Api\Users\StoreController::class)->name('store');
        Route::get('/', \App\Http\Controllers\Api\Users\IndexController::class)
            ->name('index')
            ->middleware('auth');
    });
    Route::prefix('/articles')->name('articles.')->group(function () {
        Route::get('/{slug}', \App\Http\Controllers\Api\Articles\ShowController::class)->name('show');
    });
});

// 認証あり
Route::name('api.')->middleware('auth')->group(function (){
    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', \App\Http\Controllers\Api\Users\IndexController::class)
            ->name('index');
    });
});
