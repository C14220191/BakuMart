<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    public function process(Request $request)
    {
        Log::info('Masuk ke proses pembayaran', $request->all());

        $method = $request->input('payment_method');
        $memberID = Auth::user()->id;

        $latestOrder = Order::where('user_id', $memberID)->latest()->first();
        $orderItems = OrderItem::where('order_id', $latestOrder->id)->with('product')->get();
        $subtotal = $orderItems->sum(fn($item) => $item->price * $item->quantity);

        if ($method === 'cash') {
            $latestOrder->update(['status' => 'paid_cash']);
            return redirect()->route('home')->with('success', 'Pembayaran tunai berhasil.');
        }

        $response = Http::withBasicAuth(env('XENDIT_API_KEY'), '')
            ->post('https://api.xendit.co/v2/invoices', [
                'external_id' => 'order-' . $latestOrder->id,
                'payer_email' => Auth::user()->email ?? 'example@example.com',
                'description' => 'Pembayaran BakuMart',
                'amount' => $subtotal,
                'success_redirect_url' => route('home'),
            ]);


        if ($response->failed()) {
            Log::error('Xendit Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return back()->withErrors('Gagal membuat pembayaran cashless.');
        }

        $invoiceUrl = $response->json()['invoice_url'];
        return redirect($invoiceUrl);
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
