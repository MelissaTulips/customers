<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;


// Route::apiResource('customers', CustomerController::class);
// Route::apiResource('customers.orders', OrderController::class);



Route::apiResource('customers', CustomerController::class);
Route::get('customers/{customer}/orders', [CustomerController::class, 'getOrders']);
Route::apiResource('customers.orders', OrderController::class)->only(['index', 'show']);



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
