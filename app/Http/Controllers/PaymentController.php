<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
    }

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

        $externalId = 'order-' . $latestOrder->id;
        $successUrl = route('payment.store') . '?' . http_build_query([
            'order_id' => $latestOrder->id,
        ]);

        $response = Http::withBasicAuth(env('XENDIT_API_KEY'), '')
            ->post('https://api.xendit.co/v2/invoices', [
                'external_id' => $externalId,
                'payer_email' => Auth::user()->email ?? 'example@example.com',
                'description' => 'Pembayaran BakuMart',
                'amount' => $subtotal,
                'success_redirect_url' => $successUrl,
            ]);

        if ($response->failed()) {
            Log::error('Xendit Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return back()->withErrors('Gagal membuat pembayaran cashless.');
        }

        $invoiceData = $response->json();
        Log::info('Xendit Invoice Data', $invoiceData);
        $latestOrder->update(['payment_proof' => $invoiceData['id']]);
        return redirect($invoiceData['invoice_url']);
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
        $orderId = $request->query('order_id');
        $order = Order::find($orderId);
        $invoicesId = $order->payment_proof;
        Log::info('Masuk ke store pembayaran', [
            'order_id' => $orderId,
            'invoices_id' => $invoicesId,
        ]);
        $response = Http::withBasicAuth(env('XENDIT_API_KEY'), '')
            ->get("https://api.xendit.co/v2/invoices/$invoicesId")->json();

        Log::info('response valid, lanjut create');
        Payment::create([
            'order_id' => $order->id,
            'amount' => $response['amount'],
            'payment_status' => $response['status'],
            'payment_proof' => $response['id'],
            'payment_method' => $response['payment_method'] ?? 'unknown',
            'payment_channel' => $response['payment_channel'] ?? 'unknown',
        ]);
        Log::info('invoice id', ['id' => $response['id']]);
        $order->update(['status' => 'paid']);

        return redirect()->route('home');
        // return dd($response)
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
    public function destroy(string $id) {}
}
