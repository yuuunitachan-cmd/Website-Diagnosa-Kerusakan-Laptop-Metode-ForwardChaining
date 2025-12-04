<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pakar Diagnosa Laptop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="flex items-center justify-center mb-6">
                <i class="fas fa-laptop-medical text-blue-600 text-4xl mr-3"></i>
                <h1 class="text-3xl font-bold text-gray-900">Diagnosa Laptop</h1>
            </div>
            <h2 class="text-2xl font-semibold text-gray-700">Masuk ke Akun Anda</h2>
            <p class="mt-2 text-sm text-gray-600">
                Sistem Pakar Diagnosa Kerusakan Laptop
            </p>
        </div>

        <!-- Login Form -->
        <div class="bg-white p-8 rounded-lg shadow-md">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2"></i>Alamat Email
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                           required autofocus
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="email@example.com">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <input id="password" type="password" name="password" 
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="Masukkan password">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 text-sm text-gray-700">
                            Ingat saya
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-500">
                        Lupa password?
                    </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition duration-200 font-semibold flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                </button>
            </form>

            <!-- Demo Accounts -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Akun Demo:</h3>
                <div class="space-y-1 text-xs text-gray-600">
                    <p><strong>Admin:</strong> admin@diagnosa.com / password</p>
                    <p><strong>User:</strong> user@diagnosa.com / password</p>
                </div>
            </div>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500 font-medium">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} Sistem Pakar Diagnosa Laptop. All rights reserved.</p>
        </div>
    </div>
</body>
</html>