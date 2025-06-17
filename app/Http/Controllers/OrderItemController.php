<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memberID = Auth::user()->id;
        $latestOrder = Order::where('user_id', $memberID)
            ->latest()
            ->first();
        if (!$latestOrder) {
            return response()->json(['message' => 'No orders found for this user.'], 404);
        }
        $orderItems = OrderItem::where('order_id', $latestOrder->id)
            ->with('product')
            ->get();
        if ($orderItems->isEmpty()) {
            return response()->json(['message' => 'No order items found for this order.'], 404);
        }
        $subtotal = $orderItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        
        return view('payment.index', compact('orderItems', 'subtotal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
    public function destroy(string $id)
    {
        //
    }
}
