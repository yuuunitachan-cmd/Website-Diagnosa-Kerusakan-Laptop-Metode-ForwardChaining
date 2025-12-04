<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }
        .sidebar.collapsed {
            width: 70px;
        }
        .sidebar.collapsed .sidebar-text {
            display: none;
        }
        .main-content {
            transition: all 0.3s ease;
        }
        .active-menu {
            background-color: #3b82f6;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="sidebar bg-blue-800 text-white w-64 flex flex-col" id="sidebar">
            <!-- Logo -->
            <div class="p-4 border-b border-blue-700 flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-laptop-medical text-xl mr-3"></i>
                    <span class="sidebar-text font-bold text-lg">Admin Panel</span>
                </div>
                <button id="sidebarToggle" class="text-blue-200 hover:text-white">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }}">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            <span class="sidebar-text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.gejala.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('admin.gejala.*') ? 'active-menu' : '' }}">
                            <i class="fas fa-list-check mr-3"></i>
                            <span class="sidebar-text">Data Gejala</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.kerusakan.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('admin.kerusakan.*') ? 'active-menu' : '' }}">
                            <i class="fas fa-bug mr-3"></i>
                            <span class="sidebar-text">Data Kerusakan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.basis-pengetahuan.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('admin.basis-pengetahuan.*') ? 'active-menu' : '' }}">
                            <i class="fas fa-sitemap mr-3"></i>
                            <span class="sidebar-text">Basis Pengetahuan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.history.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('admin.history.*') ? 'active-menu' : '' }}">
                            <i class="fas fa-history mr-3"></i>
                            <span class="sidebar-text">Riwayat Diagnosa</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- User Section -->
            <div class="p-4 border-t border-blue-700">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-sm"></i>
                    </div>
                    <div class="ml-3 sidebar-text">
                        <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-blue-200">Administrator</p>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-blue-700">
                    <a href="{{ route('dashboard') }}" class="flex items-center text-blue-200 hover:text-white text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span class="sidebar-text">Kembali ke User</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="flex items-center text-blue-200 hover:text-white text-sm w-full">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            <span class="sidebar-text">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b">
                <div class="flex items-center justify-between p-4">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
                        <p class="text-sm text-gray-600">@yield('subtitle', 'Sistem Pakar Diagnosa Laptop')</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-clock mr-1"></i>
                            {{ now()->format('d M Y H:i') }}
                        </span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Notifications -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @if(session('info'))
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            {{ session('info') }}
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')

    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
        });

        // Auto-hide sidebar on mobile
        function handleResize() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth < 768) {
                sidebar.classList.add('collapsed');
            } else {
                sidebar.classList.remove('collapsed');
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Initial check
    </script>
</body>
</html>