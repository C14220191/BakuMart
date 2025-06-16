@extends('base.base')

@section('content')
@include('base.navbar')

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Test</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="border p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-2">Test 1</h2>
            <p class="text-gray-600 mb-4">Desc</p>
            <p class="text-lg font-bold"> xx Price </p>
            <button class="mt-4 bg-green-600 text-black px-4 py-2 rounded hover:bg-green-700 transition">Buy Now</button>
        </div>
        <div class="border p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-2">Test 2</h2>
            <p class="text-gray-600 mb-4">Desc</p>
            <p class="text-lg font-bold"> xx Price </p>
            <button class="mt-4 bg-green-600 text-black px-4 py-2 rounded hover:bg-green-700 transition">Buy Now</button>
        </div>
        <div class="border p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-2">Test 3</h2>
            <p class="text-gray-600 mb-4">Desc</p>
            <p class="text-lg font-bold"> xx Price </p>
            <button class="mt-4 bg-green-600 text-black px-4 py-2 rounded hover:bg-green-700 transition">Buy Now</button>
        </div>
    </div>
</div>



@endsection
