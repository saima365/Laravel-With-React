<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\OrderDetail;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('customer', 'status')->get();



        return response()->json([
            'orders' => $orders
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
   public function react_order_save(Request $request)
{
    DB::beginTransaction();

    try {
       
        $order = new Order();
        $order->customer_id = $request->customer['id'];
        $order->order_total = $request->summary['total'];
        $order->paid = $request->summary['total'];
        $order->delivery_address = $request->customer['address'];
        $order->status_id = 1;
        $order->delivery_date = now();
        $order->discount_amount = $request->summary['discount'] ?? 0;
        $order->save();


        foreach ($request->cartItems as $item) {

            $orderdetail = new OrderDetail();
            $orderdetail->order_id = $order->id;
            $orderdetail->product_id = $item['id'];
            $orderdetail->quantity = $item['quantity'];
            $orderdetail->unit_price = $item['price'];
            $orderdetail->discount = $item['discount'] ?? 0;
            $orderdetail->tax = $item['tax'] ?? 0;
            $orderdetail->save();

            $stock = new Stock();
            $stock->product_id = $item['id'];
            $stock->quantity = -$item['quantity'];
            $stock->transaction_id = 1;
            $stock->warehouse_id = 1;
            $stock->date = now();
            $stock->save();
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Order Created Successfully',
            'order_id' => $order->id
        ], 201);

    } catch (\Throwable $th) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'error' => $th->getMessage()
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
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
