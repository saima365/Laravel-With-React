<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get("/supplier",[SupplierController::class,"index"]);
Route::get("/customer",[CustomerController::class,"index"]);
Route::delete('/customer/delete', [CustomerController::class, 'delete']);
Route::post('/customer/save', [CustomerController::class, 'save']);
Route::get("/order",[OrderController::class,"index"]);
Route::delete('/order/delete', [OrderController::class, 'delete']);
Route::post('/order/react_order_save', [OrderController::class, 'react_order_save']);
Route::get("/purchase",[PurchaseController::class,"index"]);
Route::post('/purchase/react_purchase_save', [PurchaseController::class, 'react_purchase_save']);
Route::delete('/purchase/delete', [PurchaseController::class, 'delete']);
Route::get("/stock",[StockController::class,"index"]);
