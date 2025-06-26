@extends('base.base')

@section('content')
    @include('base.navbar')

    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg p-6 rounded-lg">
        <h2 class="text-2xl font-bold mb-4">Riwayat Pembayaran</h2>

        @if ($payments->isEmpty())
            <p class="text-gray-600">Tidak ada riwayat pembayaran.</p>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode Pembayaran</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($payments as $payment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $payment->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $payment->payment_method }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $payments->links() }}
            </div>
        @endif
    </div>  
