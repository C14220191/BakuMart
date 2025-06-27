@include('base.navbar')
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-success mb-4">Admin Dashboard - BakuMart</h1>

    <div class="mt-4 flex gap-3">
        <a href="{{ route('admin.dashboard') }}"
            class="inline-block px-4 py-2 border-2 border-blue-600 rounded-full text-blue-600 hover:bg-blue-600 font-medium hover:text-black transition">
            Hasil Penjualan
        </a>
        <a href="{{ route('products.manage') }}"
            class="inline-block px-4 py-2 border-2 border-blue-600 rounded-full text-white bg-blue-600 font-medium hover:text-white transition">
            Manage Product
        </a>
    </div>
    <br>

    <form action="{{ route('products.manage') }}" method="GET" class="mb-4 flex gap-2">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama produk..."
            class="w-full md:w-1/3 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
            Search Product
        </button>
    </form>


    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Create Product</a>

    @php
        $sort = request('sort');
        $order = request('order', 'asc');
        $toggleOrder = $order === 'asc' ? 'desc' : 'asc';

        function sortIcon($field, $currentSort, $currentOrder) {
            if ($field === $currentSort) {
                return $currentOrder === 'asc' ? '▲' : '▼';
            }
            return '';
        }
    @endphp

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>
                    <a href="{{ route('products.manage', ['sort' => 'name', 'order' => $toggleOrder]) }}">
                        Nama Produk {{ sortIcon('name', $sort, $order) }}
                    </a>
                </th>
                <th>
                    <a href="{{ route('products.manage', ['sort' => 'price', 'order' => $toggleOrder]) }}">
                        Harga {{ sortIcon('price', $sort, $order) }}
                    </a>
                </th>
                <th>
                    <a href="{{ route('products.manage', ['sort' => 'stock', 'order' => $toggleOrder]) }}">
                        Stok {{ sortIcon('stock', $sort, $order) }}
                    </a>
                </th>
                <th>Manage</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td class="flex gap-2">
                        <a href="{{ route('products.edit', ['id' => $product->id]) }}"
                            class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-1 px-2 rounded">
                            Edit
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-2 rounded">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-red-500">Barang tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>

    </table>
    <div class="mt-4">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
