@extends('base.base')

@section('content')
    @include('base.navbar')
    <div class="sticky top-16 z-50 p-2 pr-4 flex justify-end">
        <button onclick="toggleCart()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            🛒 Cart (<span id="cartCount">0</span>)
        </button>
    </div>

    <div class="w-full max-w-7xl mx-auto px-4">
        @if (isset($bestSelling) && $bestSelling->count())
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4">Best Selling Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @foreach ($bestSelling as $product)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition cursor-pointer"
                            onclick="showProductModal('{{ asset('storage/' . $product->image) }}', '{{ $product->name }}', '{{ $product->description }}', '{{ $product->stock }}', '{{ number_format($product->price, 0, ',', '.') }}')">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                class="w-24 h-24 object-cover mx-auto mt-4 rounded" />
                            <div class="px-5 pb-5">
                                <h5 class="text-xl font-semibold text-gray-900">{{ $product->name }}</h5>
                                <p class="mt-2 text-sm text-gray-600 truncate">{{ $product->description }}</p>
                                <div class="mt-2 text-sm text-gray-800">{{ $product->stock }} in stock</div>
                                <div class="mt-3 flex flex-wrap items-center gap-2">
                                    <span class="text-xl font-bold text-gray-900">Rp.
                                        {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <button onclick="event.stopPropagation(); addToCart({{ json_encode($product) }})"
                                        class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Add
                                        to cart</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if (isset($lastProducts) && $lastProducts->count())
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4">Newest Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @foreach ($lastProducts as $product)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition cursor-pointer"
                            onclick="showProductModal('{{ asset('storage/' . $product->image) }}', '{{ $product->name }}', '{{ $product->description }}', '{{ $product->stock }}', '{{ number_format($product->price, 0, ',', '.') }}')">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                class="w-24 h-24 object-cover mx-auto mt-4 rounded" />
                            <div class="px-5 pb-5">
                                <h5 class="text-xl font-semibold text-gray-900">{{ $product->name }}</h5>
                                <p class="mt-2 text-sm text-gray-600 truncate">{{ $product->description }}</p>
                                <div class="mt-2 text-sm text-gray-800">{{ $product->stock }} in stock</div>
                                <div class="mt-3 flex flex-wrap items-center gap-2">
                                    <span class="text-xl font-bold text-gray-900">Rp.
                                        {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <button onclick="event.stopPropagation(); addToCart({{ json_encode($product) }})"
                                        class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Add
                                        to cart</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">All Product</h1>
            <div class="flex items-center gap-4">
                <select id="filterSelect"
                    class="border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Sort by</option>
                    <option value="low">Price: Low to High</option>
                    <option value="high">Price: High to Low</option>
                    <option value="asc">Name: A to Z</option>
                    <option value="desc">Name: Z to A</option>
                </select>
                <input type="text" id="searchInput" placeholder="Search products..."
                    class="border px-3 py-2 rounded w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div id="productContainer"
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 justify-center">
        </div>

        <div id="paginationContainer" class="flex justify-center mt-6 space-x-2">
        </div>
    </div>

    <div id="cartFloating"
        class="fixed right-4 bottom-4 w-80 bg-white shadow-lg rounded-lg p-4 border z-50 max-h-[500px] overflow-y-auto hidden">
        <h3 class="text-lg font-bold mb-2">Your Cart</h3>
        <ul id="cartList" class="space-y-3">
            <li class="text-gray-500">Cart is empty</li>
        </ul>
        <div class="mt-4 text-right font-semibold text-lg" id="cartTotal">Total: Rp 0</div>
        <button onclick="checkoutCart()"
            class="mt-2 w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Checkout</button>
    </div>

    <div id="productModal" onclick="closeModalOnBackground(event)"
        class="fixed inset-0 z-50 hidden bg-white/30 backdrop-blur-sm overflow-y-auto">
        <div class="relative p-4 w-full max-w-md mx-auto">
            <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-6">
                <button onclick="closeModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-900">&times;</button>
                <img id="modalImage" class="w-full h-48 object-cover rounded mb-4" src="" alt="Product Image">
                <h2 id="modalName" class="text-xl font-bold text-gray-800 dark:text-white mb-2"></h2>
                <p id="modalDescription" class="text-sm text-gray-700 dark:text-gray-300 mb-2"></p>
                <div id="modalStock" class="text-sm text-gray-800 dark:text-gray-300 mb-1"></div>
                <div id="modalPrice" class="text-lg font-semibold text-gray-900 dark:text-white mb-3"></div>
                <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Add to cart</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const isLoggedIn = @json(auth()->check());
        let cartItems = [];

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

        function addToCart(product) {
            if (!isLoggedIn) {
                window.location.href = "{{ route('login') }}";
                return;
            }


            fetch(`/api/products/${product.id}`)
                .then(res => res.json())
                .then(latestProduct => {
                    const exists = cartItems.find(p => p.id === latestProduct.id);
                    if (exists) {
                        alert("Product already in cart.");
                        return;
                    }

                    latestProduct.qty = 1;
                    cartItems.push(latestProduct);
                    renderCart();
                })
                .catch(err => {
                    console.error("Failed to fetch updated product:", err);
                    alert("Unable to add product to cart.");
                });
        }

        function removeFromCart(id) {
            cartItems = cartItems.filter(item => item.id !== id);
            renderCart();
        }

        function updateQty(id, newQty) {
            const item = cartItems.find(i => i.id === id);
            if (item) {
                const maxStock = parseInt(item.stock);
                if (newQty < 1 || newQty > maxStock) {
                    alert(`Quantity must be between 1 and ${maxStock}`);
                    return;
                }
                item.qty = newQty;
                renderCart();
            }
        }

        function renderCart() {
            const list = document.getElementById('cartList');
            const count = document.getElementById('cartCount');
            const totalContainer = document.getElementById('cartTotal');

            count.textContent = cartItems.length;

            list.innerHTML = '';
            let total = 0;

            if (cartItems.length === 0) {
                list.innerHTML = '<li class="text-gray-500">Cart is empty</li>';
                totalContainer.textContent = "Total: Rp 0";
                return;
            }

            cartItems.forEach(item => {
                const subtotal = item.qty * item.price;
                total += subtotal;

                const li = document.createElement('li');
                li.className = 'flex flex-col bg-gray-50 rounded p-2 border';

                li.innerHTML = `
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-semibold text-sm">${item.name}</span>
                        <button onclick="removeFromCart(${item.id})" class="text-red-500 text-sm hover:underline">Remove</button>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-sm">Qty:</label>
                        <input type="number" min="1" max="${item.stock}" value="${item.qty}"
                            onchange="updateQty(${item.id}, this.value)"
                            class="w-16 border px-2 py-1 rounded text-sm">
                        <span class="text-sm text-gray-700 ml-auto whitespace-nowrap">Rp ${subtotal}</span>
                    </div>
                `;
                list.appendChild(li);
            });

            totalContainer.textContent = `Total: Rp ${total}`;
        }

        function toggleCart() {
            const cart = document.getElementById('cartFloating');
            cart.classList.toggle('hidden');
        }

        function checkoutCart() {
            if (!isLoggedIn) {
                window.location.href = "{{ route('login') }}";
                return;
            }

            if (cartItems.length === 0) {
                alert("Your cart is empty!");
                return;
            }

            fetch("{{ route('checkout.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        items: cartItems
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        cartItems = [];
                        renderCart();
                        window.location.href = data.redirect;
                    } else {
                        if (data.message) {
                            alert(data.message);
                            window.location.href = data.redirect;
                        } else {
                            alert("Checkout failed.");
                        }
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Error processing checkout.");
                });
        }


        $(document).ready(function() {
            function loadProducts(page = 1, search = '', filter = '') {
                $.get("{{ route('products.ajaxList') }}", {
                    page,
                    search,
                    filter
                }, function(data) {
                    const container = $('#productContainer');
                    container.empty();

                    data.products.forEach(product => {
                        container.append(`
                <div onclick="showProductModal('${product.image_url}', '${product.name}', '${product.description}', '${product.stock}', '${product.price}')"
                    class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition cursor-pointer">
                    <img src="${product.image_url}" alt="product image"
                        class="w-24 h-24 object-cover mx-auto mt-4 rounded" />
                    <div class="px-5 pb-5">
                        <h5 class="text-xl font-semibold text-gray-900">${product.name}</h5>
                        <p class="mt-2 text-sm text-gray-600 truncate">${product.description}</p>
                        <div class="mt-2 text-sm text-gray-800">${product.stock} in stock</div>
                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            <span class="text-xl font-bold text-gray-900">Rp. ${product.price}</span>
                            <button onclick='event.stopPropagation(); addToCart(${JSON.stringify(product)})'
                                class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Add to cart</button>
                        </div>
                    </div>
                </div>
            `);
                    });

                    $('#paginationContainer').html(data.pagination);
                });
            }


            loadProducts();

            $('#filterSelect, #searchInput').on('input change', function() {
                const search = $('#searchInput').val();
                const filter = $('#filterSelect').val();
                loadProducts(1, search, filter);
            });


            $(document).on('click', '#paginationContainer a', function(e) {
                e.preventDefault();
                const url = new URL($(this).attr('href'));
                const page = url.searchParams.get("page");
                const search = $('#searchInput').val();
                const filter = $('#filterSelect').val();
                loadProducts(page, search, filter);
            });

        });
    </script>
@endpush
