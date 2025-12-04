<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar Diagnosa Kerusakan Laptop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-laptop-medical text-blue-600 text-2xl"></i>
                    <span class="text-xl font-bold text-gray-800">Diagnosa Laptop</span>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 transition">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-blue-600 transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-16">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-4xl mx-auto">
                <i class="fas fa-laptop-medical text-blue-600 text-6xl mb-6"></i>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                    Sistem Pakar Diagnosa Kerusakan Laptop
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    Gunakan kecerdasan buatan untuk mendiagnosa kerusakan laptop Anda dengan metode 
                    <strong class="text-blue-600">Forward Chaining</strong>. Dapatkan solusi tepat dalam hitungan detik.
                </p>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <div class="bg-white rounded-lg p-6 shadow-md">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $totalDiagnosa }}</div>
                        <p class="text-gray-600">Diagnosa Dilakukan</p>
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md">
                        <div class="text-3xl font-bold text-green-600 mb-2">{{ $totalGejala }}</div>
                        <p class="text-gray-600">Gejala Terdeteksi</p>
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md">
                        <div class="text-3xl font-bold text-purple-600 mb-2">{{ $totalKerusakan }}</div>
                        <p class="text-gray-600">Jenis Kerusakan</p>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('diagnosa.index') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition flex items-center justify-center">
                            <i class="fas fa-stethoscope mr-3"></i>Mulai Diagnosa
                        </a>
                        <a href="{{ route('dashboard') }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition flex items-center justify-center">
                            <i class="fas fa-tachometer-alt mr-3"></i>Dashboard Saya
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-3"></i>Login untuk Diagnosa
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition flex items-center justify-center">
                            <i class="fas fa-user-plus mr-3"></i>Daftar Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Mengapa Menggunakan Sistem Kami?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center p-6">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-sitemap text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Forward Chaining</h3>
                    <p class="text-gray-600">
                        Menggunakan metode inferensi cerdas dari fakta menuju kesimpulan untuk diagnosa yang akurat.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center p-6">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bolt text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Cepat & Akurat</h3>
                    <p class="text-gray-600">
                        Proses diagnosa hanya dalam hitungan detik dengan tingkat akurasi yang tinggi.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center p-6">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lightbulb text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Solusi Tepat</h3>
                    <p class="text-gray-600">
                        Dapatkan solusi spesifik dan dapat diikuti untuk setiap jenis kerusakan laptop.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Cara Kerja Sistem</h2>
            
            <div class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">1</div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Pilih Gejala</h3>
                        <p class="text-gray-600 text-sm">Pilih gejala yang dialami laptop Anda</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-green-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">2</div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Proses AI</h3>
                        <p class="text-gray-600 text-sm">Sistem memproses dengan Forward Chaining</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-purple-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">3</div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Hasil & Solusi</h3>
                        <p class="text-gray-600 text-sm">Dapatkan diagnosa dan solusi tepat</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <div class="flex items-center justify-center mb-4">
                <i class="fas fa-laptop-medical text-blue-400 text-2xl mr-3"></i>
                <span class="text-xl font-bold">Diagnosa Laptop</span>
            </div>
            <p class="text-gray-400">
                Sistem Pakar Diagnosa Kerusakan Laptop menggunakan Metode Forward Chaining
            </p>
            <p class="text-gray-400 mt-2">
                &copy; {{ date('Y') }} All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>