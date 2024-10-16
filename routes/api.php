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

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('/login', 'login')->name('auth.login')->middleware(['throttle:15,3']);
            Route::post('/logout', 'logout')->name('auth.logout')->middleware(['auth:sanctum']);
            Route::get('/me', 'me')->name('auth.me')->middleware(['auth:sanctum']);
        });
    });

    Route::controller(UserController::class)->group(function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', 'show')->name('user.show');
            Route::post('/', 'store')->name('user.store');
            Route::put('/{id}', 'update')->name('user.update');
            Route::delete('/{id}', 'delete')->name('user.delete');
        });
    });

    Route::controller(TodoListController::class)->group(function () {
        Route::group(['prefix' => 'todolist'], function () {
            Route::get('/', 'show')->name('todolist.show')->middleware(['auth:sanctum']);
            Route::get('/{id}', 'detail')->name('todolist.detail')->middleware(['auth:sanctum']);
            Route::post('/', 'store')->name('todolist.store')->middleware(['auth:sanctum']);
            Route::put('/{id}', 'update')->name('todolist.update')->middleware(['auth:sanctum']);
            Route::delete('/{id}', 'delete')->name('todolist.delete')->middleware(['auth:sanctum']);
        });
    });

});

