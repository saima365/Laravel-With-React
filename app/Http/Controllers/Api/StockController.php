<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
public function index()
{
    $stocks = Stock::with('product')->get();



    return response()->json([
        'stocks' => $stocks
    ]);
}
}
