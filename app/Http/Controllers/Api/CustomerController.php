<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers=Customer::all();
       return response()->json(compact("customers"), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
{
    $id = $request->id; // get ID from request body
    $customer = Customer::findOrFail($id);
    $customer->delete();

    return response()->json([
        'message' => 'Deleted successfully'
    ]);
}

}
