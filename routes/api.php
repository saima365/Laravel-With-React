<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Route::controller(AuthController::class)->group(function(){

// });


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get("/customer",[CustomerController::class,"index"]);
Route::get("/order",[OrderController::class,"index"]);
