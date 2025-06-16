@extends('base.base')

@section('content')

    <section class="bg-green-100 py-16">
        <div class="container mx-auto text-center px-4">
            <h1 class="text-4xl font-bold text-green-700 mb-4">Selamat Datang di BaKuMart</h1>
            <p class="text-lg text-gray-700 mb-6">Belanja mudah, cepat, dan terpercaya. Temukan produk kebutuhanmu di sini!</p>
            <a style=" color: black" href="{{ route('products.index') }}"
               class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-green-700 transition">
                Mulai Belanja
            </a>
        </div>
    </section>
@endsection
