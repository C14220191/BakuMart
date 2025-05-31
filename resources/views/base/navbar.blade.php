<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite('resources/css/app.css')
</head>

<body>
    <nav class="bg-[#43be37] px-4 py-3">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Kiri: Logo -->
            <a href="#" class="text-white text-xl font-bold">BaKuMart</a>

            <!-- Tengah (untuk menu desktop) -->
            <div class="hidden md:flex space-x-6">
                <a href="#" class="text-white hover:underline">Home</a>
                <a href="#" class="text-white hover:underline">Features</a>
                <a href="#" class="text-white hover:underline">Pricing</a>
            </div>

            <!-- Kanan: Login -->
            <div class="hidden md:block">
                <a href="{{ route('login') }}" class="text-white hover:underline">Login</a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button id="menu-button" class="text-white focus:outline-none focus:ring-2 focus:ring-white">
                    <!-- Icon: hamburger -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            <script>
                document.getElementById('menu-button').addEventListener('click', function() {
                    const menu = document.getElementById('mobile-menu');
                    menu.classList.toggle('hidden');
                });
            </script>

        </div>

        <!-- Mobile menu (hidden by default) -->
        <div id="mobile-menu" class="md:hidden hidden px-4 mt-2 space-y-2">
            <a href="#" class="block text-white hover:underline">Home</a>
            <a href="#" class="block text-white hover:underline">Features</a>
            <a href="#" class="block text-white hover:underline">Pricing</a>
            <a href="{{ route('login') }}" class="block text-white hover:underline">Login</a>
        </div>
    </nav>


    <div class="container-fluid mt-4">
        @yield('content')
    </div>

    @vite('resources/js/app.js')
</body>

</html>
