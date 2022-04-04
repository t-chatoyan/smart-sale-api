<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
header('Access-Control-Allow-Origin: *');
//Access-Control-Allow-Origin: *
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
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
    Route::group(['middleware' => ['jwt.verify:user']], function () {
        Route::get('all-shops', [\App\Http\Controllers\User\ShopController::class, 'getAllShops']);

        //ShopController
        Route::resource('shop', \App\Http\Controllers\User\ShopController::class);
        Route::get('shop/{id}/restore', [\App\Http\Controllers\User\ShopController::class, 'restore']);
        Route::post('shop-update/{id}', [\App\Http\Controllers\User\ShopController::class, 'update']);
        Route::delete('delete-shop-branch/{id}', [\App\Http\Controllers\User\ShopController::class, 'deleteShopBranch']);

        //ProductController
        Route::resource('product', \App\Http\Controllers\User\ProductController::class);
        Route::get('product/{id}/restore', [\App\Http\Controllers\User\ProductController::class, 'restore']);
        Route::delete('delete-product-photo/{id}/', [\App\Http\Controllers\User\ProductController::class, 'deleteProductPhoto']);

        //MediaController
        Route::delete('media/{uuid}', [\App\Http\Controllers\User\MediaController::class, 'destroy']);

        Route::resource('category', \App\Http\Controllers\User\CategoryController::class);

        Route::resource('dashboard', \App\Http\Controllers\User\DashboardController::class);

    });
});


// customer api
Route::group(['prefix' => 'customer'], function () {


    //Shop
    Route::resource('shops', \App\Http\Controllers\Customer\ShopController::class);
    Route::get('top-shop', [\App\Http\Controllers\Customer\ShopController::class, 'topShops']);


    //CategoryController
    Route::get('category', [\App\Http\Controllers\Customer\CategoryController::class, 'index']);
    Route::get('category/{id}', [\App\Http\Controllers\Customer\CategoryController::class, 'show']);

    //ProductController
    Route::get('product', [\App\Http\Controllers\Customer\ProductController::class, 'index']);
    Route::get('top-product', [\App\Http\Controllers\Customer\ProductController::class, 'topProduct']);
    Route::get('product/{id}', [\App\Http\Controllers\Customer\ProductController::class, 'show']);
});

Route::post('test', [\App\Http\Controllers\Customer\ProductController::class, 'test']);
Route::get('test', [\App\Http\Controllers\Customer\ProductController::class, 'shoTest']);
