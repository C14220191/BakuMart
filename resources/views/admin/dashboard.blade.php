@include('base.navbar')
@extends('layouts.app')



@section('content')
<div class="container">
    <h1 class="text-success mb-4">Admin Dashboard - BakuMart</h1>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <div>

            <a href="{{ route('products.create') }}" class="btn btn-success me-2">
                Create Product
            </a>
            <a href="{{ route('products.edit', ['id' => 1]) }}" class="btn btn-warning">
                Edit Product
            </a>
        </div>
    </div>

    
    <h3 class="mt-5">Grafik Penjualan Bulanan</h3>
    <canvas id="salesChart" height="100"></canvas>

    <h3>Data Penjualan User</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama User</th>
                <th>Tanggal Order</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
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
