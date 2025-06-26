<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BakuMart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @yield('styles')
</head>
<body>
        <div class="ml-auto">
            @auth
                <span class="text-white me-2">Welcome, {{ auth()->user()->name }}</span>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light me-2">Admin Dashboard</a>
                @else
                    <a href="{{ route('home') }}" class="btn btn-outline-light me-2">Home</a>
                @endif            
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
            @endauth
        </div>
    </nav>

    <main class="py-4 container">
        @yield('content')
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
