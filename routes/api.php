<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\StockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get("/customer",[CustomerController::class,"index"]);
Route::delete('/customer/delete', [CustomerController::class, 'delete']);
Route::get("/order",[OrderController::class,"index"]);
Route::get("/purchase",[PurchaseController::class,"index"]);
Route::get("/stock",[StockController::class,"index"]);
