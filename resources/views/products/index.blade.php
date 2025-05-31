@extends('base.base')

@section('content')
@include('base.navbar')
<h1 class="container justify-center ml-28 text-2xl font-bold">All Product</h1>
    <div class="flex justify-center mt-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6 max-w-screen-xl">
            @foreach ($listProducts->take(15) as $product)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <img src="{{ asset('storage/images/' . $product->image) }}" alt="product image"
                            class="w-24 h-24 object-cover mx-auto mt-4 rounded" />
                    </a>
                    <div class="px-5 pb-5">
                        <a href="#">
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                {{ $product->name }}</h5>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $product->description }}</p>
                        </a>
                        <div class="mt-2 text-sm text-gray-800 dark:text-gray-300 w-fit">
                            {{ $product->stock }} in stock
                        </div>
                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            <span class="text-xl font-bold text-gray-900 dark:text-white w-fit">Rp. {{ $product->price }}</span>
                            <a href="#"
                                class="inline-flex w-fit text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                                to cart</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
