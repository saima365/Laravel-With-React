<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
      public function index()
    {
        $suppliers=Supplier::all();
        $products=Product::all();


       return response()->json(compact("suppliers","products"), 200);
    }
}
