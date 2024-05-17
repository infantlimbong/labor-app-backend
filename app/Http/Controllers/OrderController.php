<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        return response()->json(['message' => 'Successfully fetched Orders', 'data' => $orders], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestedData = $request->all();

        // Automatically set the authenticared user.id to order.user_id
        $requestedData['user_id'] = auth()->id();
        $order = Order::create($requestedData);
        return response()->json(['message' => 'Order successfully created', 'data' => $order], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return response()->json(['message' => 'Successfully fetched Order', 'data' => $order], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return response()->json(['message' => 'Order successfully updated', 'data' => $order], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Order successfully deleted'], 200);
    }
}