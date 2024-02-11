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
        Route::get('/', \App\Http\Controllers\Api\User\IndexController::class)
            ->name('index')
            ->middleware('auth');
    });
    Route::prefix('/articles')->name('articles.')->group(function () {
        Route::get('/{slug}', \App\Http\Controllers\Api\Articles\ShowController::class)->name('show');
    });
    Route::prefix('/profiles')->name('profiles.')->group(function () {
        Route::prefix('/{user:username}')->name('username.')->group(function () {
            Route::get('/', \App\Http\Controllers\Api\Profiles\Username\ShowController::class)->name('show');
            Route::post('/follow', \App\Http\Controllers\Api\Profiles\Username\Follow\StoreController::class)->name('follow.store');
            Route::delete('/follow', \App\Http\Controllers\Api\Profiles\Username\Follow\DeleteController::class)->name('follow.delete');
        });
    });
});

// 認証あり
Route::name('api.')->middleware('auth')->group(function () {
    Route::prefix('/user')->name('user.')->group(function () {
        Route::get('/', \App\Http\Controllers\Api\User\IndexController::class)
            ->name('index');
        Route::put('/', \App\Http\Controllers\Api\User\UpdateController::class)
            ->name('store');
    });
});
