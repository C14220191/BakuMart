@extends('base.base')
@section('content')
    <section class="bg-gray-50">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Add New Product
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Product Name</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Product Name" required="">
                        </div>
                        <div>
                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Price</label>
                            <input type="number" name="price" id="price" placeholder="$0.00"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                required="">
                        </div>
                        <div>
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                            <textarea name="description" id="description"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Product Description" required=""></textarea>
                        </div>
                        <div>
                            <label for="stock" class="block mb-2 text-sm font-medium text-gray-900">Stock Quantity</label>
                            <input type="number" name="stock" id="stock"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Stock Quantity" required="">
                        </div>
                        <div>
                            <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Product Image</label>
                            <input type="file" name="image" id="image"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                accept="image/*">
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-[#43be37] hover:bg-[#3aa730] focus:ring-4 focus:outline-none focus:ring-[#a5f0a0] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Add Product
                        </button>
                        <p class="text-sm font-light text-gray-500">
                            <a href="{{ route('products.index') }}" class="font-medium text-primary-600 hover:underline">Back to Products</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

