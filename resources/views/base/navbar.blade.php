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
            <a href="/" class="text-white text-xl font-bold">BaKuMart</a>

            <div class="hidden md:flex space-x-6">
                <a href="/" class="hover:underline">Home</a>
                <a href="/history" class="hover:underline">History</a>

            </div>
            @auth
            <div class="hidden md:block relative">
                <button id="user-menu-button" class="text-white focus:outline-none focus:ring-2 focus:ring-white">
                    welcome, {{ auth()->user()->name }}
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11a4 4 0 11-8 0 4 4 0 018 0zM12 14a7.002 7.002 0 00-6.32 4.5A9.003 9.003 0 0112 21a9.003 9.003 0 016.32-2.5A7.002 7.002 0 0012 14z"></path>
                    </svg>
                </button>
                <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden">
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ url('/admin/dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                            Dashboard Admin
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
                </div>
                <script>
                    document.getElementById('user-menu-button').addEventListener('click', function() {
                        const menu = document.getElementById('user-menu');
                        menu.classList.toggle('hidden');
                    });
                </script>
            </div>
                @else
                <div class="hidden md:block">
                <a href="{{ route('login') }}" class="text-white hover:underline">Login</a>
            </div>
            @endauth
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
            <a href="{{ route('home') }}" class="block text-white hover:underline">Home</a>
            <a href="{{ route('payment.history') }}" class="block text-white hover:underline">History</a>
            <a href="{{ route('login') }}" class="block text-white hover:underline">Login</a>
        </div>
    </nav>


    <div class="container-fluid mt-4">
        @yield('content')
    </div>

    @vite('resources/js/app.js')
</body>

</html>
