<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Pakar Diagnosa Laptop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-laptop-medical text-2xl"></i>
                    <a href="{{ url('/') }}" class="text-xl font-bold">Diagnosa Laptop</a>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-blue-100">Halo, {{ auth()->user()->name }}</span>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-200 transition">
                                <i class="fas fa-cog mr-1"></i>Admin
                            </a>
                        @endif
                        <a href="{{ route('diagnosa.index') }}" class="hover:text-blue-200 transition">
                            <i class="fas fa-stethoscope mr-1"></i>Diagnosa
                        </a>
                        <a href="{{ route('diagnosa.riwayat') }}" class="hover:text-blue-200 transition">
                            <i class="fas fa-history mr-1"></i>Riwayat
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-blue-200 transition">
                                <i class="fas fa-sign-out-alt mr-1"></i>Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-blue-200 transition">Login</a>
                        <a href="{{ route('register') }}" class="hover:text-blue-200 transition">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Sistem Pakar Diagnosa Kerusakan Laptop. All rights reserved.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>