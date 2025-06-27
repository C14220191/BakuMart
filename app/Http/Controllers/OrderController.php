<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Dotenv\Util\Str;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listOrders = Order::with('orderItems.product')->where('user_id', Auth::id())->get();

        return view('payment.history', [
            'orders' => $listOrders,
        ]);
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
        $order = Order::where('user_id', Auth::user()->id)
            ->where('status', 'pending')
            ->first();
        if ($order) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a pending order. Please complete or cancel it before creating a new one.',
                'redirect' => route('payment.index'),
            ]);
        }

        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);
        $total = collect($request->items)->sum(function ($item) {
            return $item['price'] * $item['qty'];
        });
        $order = Order::create([

            'user_id' => Auth::user()->id,
            'order_date' => Carbon::now()->toDateString(),
            'status' => 'pending',
            'total' => $total,
        ]);
        $orderItems = collect($request->items)->map(function ($item) use ($order) {
            return [
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['qty'],
                'price' => $item['price'],
            ];
        })->toArray();
        OrderItem::insert($orderItems);
        // Update product stock
        foreach ($request->items as $item) {
            $product = Product::find($item['id']);
            $product->decrement('stock', $item['qty']);
        }
        return response()->json([
            'success' => true,
            'redirect' => route('payment.index'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $order = Order::with('orderItems.product', 'payment')->findOrFail($id);
        return view('payment.detail', [
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'cancelled']);
        $order->delete();
        $orderItems = OrderItem::where('order_id', $id)->get();
        foreach ($orderItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
            $item->delete();
        }
        return redirect()->route('home')->with('success', 'Order berhasil dibatalkan.');
    }
}
