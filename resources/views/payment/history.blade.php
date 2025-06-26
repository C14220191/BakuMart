@extends('base.base')

@section('content')
    @include('base.navbar')

    <div class="max-w-4xl mx-auto mt-10 px-4">
        <h2 class="text-2xl font-bold mb-4">Riwayat Belanja</h2>

        @if ($orders->isEmpty())
            <p class="text-gray-500">Anda belum melakukan pembelian.</p>
        @else
            <div class="space-y-6">
                @foreach ($orders as $order)
                    @php
                        $firstItem = $order->orderItems->first();
                        $otherItemCount = $order->orderItems->count() - 1;
                    @endphp

                    <div
                        class="bg-white rounded-lg shadow-md p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex gap-4 items-start sm:items-center w-full sm:w-auto">
                            <img src="{{ URL::asset('/storage/' . $firstItem->product->image) }}" alt="Product Image"
                                class="w-20 h-20 object-cover rounded border">
                            <div>
                                <h3 class="font-semibold text-base sm:text-lg">{{ $firstItem->product->name }}</h3>
                                @if ($otherItemCount > 0)
                                    <p class="text-gray-500 text-sm mt-1">+{{ $otherItemCount }} produk lainnya</p>
                                @endif
                                <p class="text-sm text-gray-600 mt-1">Total Belanja:
                                    <strong>Rp{{ number_format($order->total, 0, ',', '.') }}</strong></p>
                                <p class="text-sm text-gray-600">Tanggal:
                                    {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>
                            </div>
                        </div>

                        <div class="mt-4 sm:mt-0 sm:text-right w-full sm:w-auto">
                            <span
                                class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                            {{ $order->status == 'Selesai' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                {{ $order->status }}
                            </span>
                            <div class="mt-2">
                                <a href="#" class="text-blue-600 hover:underline text-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
