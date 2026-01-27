<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with('supplier','status')->get();



    return response()->json([
        'purchases' => $purchases
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */


public function react_purchase_save(Request $request)
{


    DB::beginTransaction();


    try {

        $purchase = new Purchase();
        $purchase->supplier_id = $request->supplier['id'];
        $purchase->subtotal = $request->summary['subtotal'] ?? 0;
        $purchase->discount_amount = $request->summary['discount'] ?? 0;
        $purchase->net_total = $request->summary['grandTotal'] ?? 0;
        $purchase->status_id = $request->status ?? 1;
        $purchase->save();

        foreach ($request->cartItems as $item) {


            $purchasedetail = new PurchaseDetail();
            $purchasedetail->purchase_id = $request->id;
            $purchasedetail->product_id = $item['id'];
            $purchasedetail->quantity = $item['quantity'];
            $purchasedetail->unit_price = $item['price'];
            $purchasedetail->discount = $item['discount'] ?? 0;
            $purchasedetail->save();

            $stock = new Stock();
            $stock->product_id = $item['id'];
            $stock->quantity = +$item['quantity'];
            $stock->transaction_id = 1;
            $stock->warehouse_id = 1;
            $stock->date = now();
            $stock->save();
        }

        DB::commit();

        return response()->json([
           'success' => true,
            'message' => 'Order Created Successfully',
            'purchase_id' => $purchase->id
        ], 201);

    } catch (\Throwable $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
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
    $purchase = Purchase::findOrFail($id);
    $purchase->delete();

    return response()->json([
        'message' => 'Deleted successfully'
    ]);
}
}
