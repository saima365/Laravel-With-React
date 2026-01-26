<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers=Customer::all();
        $products=Product::all();
       return response()->json(compact("customers","products"), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request)
    {
        $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|unique:customers,email',
        'phone'   => 'required|string|max:20',
        'address' => 'required|string',
        'photo'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $customer = new Customer();
    $customer->name = $request->name;
    $customer->email = $request->email;
    $customer->phone = $request->phone;
    $customer->address = $request->address;


    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('customers', 'public');
        $customer->photo = $path;
    }

    $customer->save();

    return response()->json([
        'success' => true,
        'customer' => $customer
    ], 201);
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
    $id = $request->id;
    $customer = Customer::findOrFail($id);
    $customer->delete();

    return response()->json([
        'message' => 'Deleted successfully'
    ]);
}

}
