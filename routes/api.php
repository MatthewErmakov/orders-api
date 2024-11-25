<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

Route::get('/', function() {
   return response()->json([
       'error' => [
           'message' => 'Forbidden.'
       ]
   ], 403);
});

Route::controller(UserController::class)
    ->prefix('auth')
    ->group(function () {
        Route::post('login', 'login')->name('login');
        Route::post('register', 'register')->name('register');
    });

Route::controller(OrderController::class)
    ->prefix('orders')
    ->group(function() {
        // create
        Route::post('', 'store')->name('orders.store');

        // read
        Route::get('', 'index')->name('orders.index');
        Route::get('{order}', 'show')->name('orders.show');

        // update
        Route::patch('{order}', 'update')->name('orders.update');

        // delete
        Route::delete('{order}', 'destroy')->name('orders.destroy');
    });

