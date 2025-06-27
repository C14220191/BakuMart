@include('base.navbar')
@extends('layouts.app')

@section('content')


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
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Create Product</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <a href="{{ route('products.edit', ['id' => $product->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('products.destroy', ['id' => $product->id]) }}" class="btn btn-warning btn-sm">Delete</a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

