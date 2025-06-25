@extends('base.base')
@section('content')
    @include('base.navbar')
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg p-6 rounded-lg">
        <h2 class="text-2xl font-bold mb-4">Ringkasan Pembelian</h2>

        @foreach ($orderItems as $item)
            <div class="flex items-center mb-4">
                <img src="{{ $item->product->image_url ?? 'https://via.placeholder.com/80' }}"
                    alt="{{ $item->product->name }}" class="w-20 h-20 object-cover mr-4 rounded-md border">
                <div class="flex-1">
                    <h3 class="font-semibold text-lg">{{ $item->product->name }}</h3>
                    <p>Jumlah: {{ $item->quantity }}</p>
                    <p class="font-semibold text-indigo-600">Total:
                        Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                </div>
            </div>
        @endforeach

        <hr class="my-4">

        <div class="text-right">
            <p class="text-lg font-bold mt-2">Total: Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
        </div>

        <form method="POST" action="{{ route('payment.process') }}" class="mt-6">
            @csrf
            <div class="mb-4">
                <label class="font-medium block mb-2">Metode Pembayaran</label>
                <label class="inline-flex items-center mr-4">
                    <input type="radio" name="payment_method" value="cash" class="form-radio text-indigo-600" required>
                    <span class="ml-2">Tunai</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="payment_method" value="cashless" class="form-radio text-indigo-600"
                        required>
                    <span class="ml-2">Cashless</span>
                </label>
            </div>
            <button type="submit"
                class="w-full bg-indigo-600 text-white py-3 rounded-lg text-lg font-semibold mb-2 hover:bg-indigo-700 transition">
                Selesaikan Pembayaran
            </button>
        </form>

        <form method="POST" action="{{ url('/order/destroy/' . $item->order_id) }}" class="mt-2">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="w-full bg-red-600 text-white py-3 rounded-lg text-lg font-semibold hover:bg-red-700 transition">
                Cancel Order
            </button>
        </form>


    </div>
@endsection
