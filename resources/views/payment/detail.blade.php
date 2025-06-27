@extends('base.base')

@section('content')
    @include('base.navbar')

    <div class="max-w-4xl mx-auto mt-10 px-4 space-y-6 mb-5">

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold text-green-600 mb-2">Pesanan Selesai</h2>
            <p class="text-sm text-gray-700">No. Pesanan: {{ $order->id }}</p>
            <p class="text-sm text-gray-700">Tanggal Pembelian:
                {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y, H:i') }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Detail Produk</h3>
            @foreach ($order->orderItems as $item)
                <div class="flex items-center gap-4 mb-4">
                    <img src="{{ $item->product->image_url ?? 'https://via.placeholder.com/80' }}"
                        alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded border">
                    <div class="flex-1">
                        <h4 class="font-medium">{{ $item->product->name }}</h4>
                        <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} x
                            Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                        <p class="text-sm font-semibold text-indigo-700">
                            Total: Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Rincian Pembayaran</h3>

            @php
                $subtotal = $order->orderItems->sum(fn($i) => $i->quantity * $i->price);
                $total = $order->total;
            @endphp

            <ul class="text-sm text-gray-700 space-y-1">
                <li class="flex justify-between">
                    <span>Subtotal Harga Barang</span>
                    <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                </li>
            </ul>

            <hr class="my-3">

            <div class="flex justify-between font-bold text-lg">
                <span>Total Belanja</span>
                <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>


        <a href="{{ route('payment.history') }}"
            class="w-full bg-green-600 text-white font-semibold py-2 rounded hover:bg-green-700 flex items-center justify-center">
            Kembali
        </a>


    </div>
@endsection
