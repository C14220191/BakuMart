@extends('base.base')

@section('content')
    @include('base.navbar')
    <h1 class="container justify-center ml-28 text-2xl font-bold">All Product</h1>
    <div class="flex justify-center mt-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6 max-w-screen-xl">
            @foreach ($listProducts->take(15) as $product)
                <div onclick="showProductModal('{{ asset('storage/' . $product->image) }}', '{{ $product->name }}', `{{ $product->description }}`, '{{ $product->stock }}', '{{ $product->price }}')"
                    class="cursor-pointer bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 hover:shadow-md transition">

                    <img src="{{ asset('storage/' . $product->image) }}" alt="product image"
                        class="w-24 h-24 object-cover mx-auto mt-4 rounded" />

                    <div class="px-5 pb-5">

                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                            {{ $product->name }}</h5>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 truncate">{{ $product->description }}
                        </p>

                        <div class="mt-2 text-sm text-gray-800 dark:text-gray-300 w-fit">
                            {{ $product->stock }} in stock
                        </div>
                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            <span class="text-xl font-bold text-gray-900 dark:text-white w-fit">Rp.
                                {{ $product->price }}</span>
                            <a href="#"
                                class="inline-flex w-fit text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                                to cart</a>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- Modal -->
            <div id="productModal" onclick="closeModalOnBackground(event)"
                class="fixed inset-0 z-50 hidden bg-white/30 backdrop-blur-sm overflow-y-auto">

                <div class="relative p-4 w-full max-w-md mx-auto">
                    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-6">
                        <button onclick="closeModal()"
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-900">&times;</button>
                        <img id="modalImage" class="w-full h-48 object-cover rounded mb-4" src=""
                            alt="Product Image">
                        <h2 id="modalName" class="text-xl font-bold text-gray-800 dark:text-white mb-2"></h2>
                        <p id="modalDescription" class="text-sm text-gray-700 dark:text-gray-300 mb-2"></p>
                        <div id="modalStock" class="text-sm text-gray-800 dark:text-gray-300 mb-1"></div>
                        <div id="modalPrice" class="text-lg font-semibold text-gray-900 dark:text-white mb-3"></div>
                        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Add to cart</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
<script>
    function showProductModal(image, name, description, stock, price) {
        document.getElementById('modalImage').src = image;
        document.getElementById('modalName').textContent = name;
        document.getElementById('modalDescription').textContent = description;
        document.getElementById('modalStock').textContent = `${stock} in stock`;
        document.getElementById('modalPrice').textContent = `Rp. ${price}`;
        document.getElementById('productModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('productModal').classList.add('hidden');
    }

    function closeModalOnBackground(event) {
        const modalContent = event.target.closest('.modal-content');
        if (!modalContent) {
            closeModal();
        }
    }
</script>
