@include('base.navbar')
@extends('layouts.app')

@section('content')

@section('content')
    <div class="container">
        <h1 class="text-success mb-4">Admin Dashboard - BakuMart</h1>
        <div class="mt-4 flex gap-3">
            <a href="{{ route('admin.dashboard') }}"
            class="inline-block px-4 py-2 border-2 border-white rounded-full text-white font-medium bg-blue-600 hover:text-white transition">
                Hasil Penjualan
            </a>
            <a href="{{ route('products.manage') }}"
            class="inline-block px-4 py-2 border-2 border-blue-600 rounded-full text-blue-600 font-medium hover:bg-blue-600 hover:text-white transition">
                Manage Product
            </a>
        </div>
        <h3 class="mt-5">Grafik Penjualan Bulanan</h3>
        <canvas id="salesChart" height="100"></canvas>

        <h3>Data Penjualan User</h3>
        <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder=" Cari Nama User.." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button 
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit" type="submit">Search User
                </button>
                </div>
            </div>
        </form>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama User</th>
                    <th>Tanggal Order</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>

                        @if ($order->status === 'paid' || $order->status === 'completed' || $order->status === 'paid_cash')
                            <td>{{ $order->user->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ $order->payment_proof }} </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $orders->links() }}
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($salesChart->pluck('month')) !!},
                datasets: [{
                    label: 'Total Penjualan (Rp)',
                    data: {!! json_encode($salesChart->pluck('total_sales')) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Total Penjualan per Bulan' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });

    </script>
@endsection