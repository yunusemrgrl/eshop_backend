<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\CakeOffersController;
use App\Http\Controllers\ProductsController;

Route::group([
    'middleware' => 'api',
    'prefix' => "auth"
], function ($router) {
    Route::post('login', [AuthController::class, 'login'])->name("login");
    Route::post('register', [AuthController::class, 'register'])->name("register");
    Route::post('update', [AuthController::class, 'update']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});



Route::group([
    'middleware' => "api",
    'prefix' => "product"
],function($router){

    Route::get('get',[ProductsController::class,"getProducts"]);
    Route::post('getProduct',[ProductsController::class,"getProduct"]);
    Route::post('add',[ProductsController::class,"store"]);
    Route::post('addShoppingCart',[ProductsController::class,"addShoppingCart"]);
    Route::post('addOrder',[ProductsController::class,"addOrder"]);
    Route::post('getOrder',[ProductsController::class,"getOrder"]);
    Route::post('getAllOrder',[ProductsController::class,"getAllOrder"]);
    Route::post('confirmOrder',[ProductsController::class,"confirmOrder"]);

});



