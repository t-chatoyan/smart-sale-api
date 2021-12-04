<?php

use App\Http\Controllers\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// user api
Route::group(['prefix' => 'user'], function () {
    Route::post('login', [\App\Http\Controllers\User\UserController::class, 'login']);
    Route::resource('shop', \App\Http\Controllers\User\ShopController::class);
});
