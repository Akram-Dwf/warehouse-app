<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventra - Warehouse Management System</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="antialiased bg-gray-50 text-gray-800">
    
    <div class="relative min-h-screen flex flex-col justify-center items-center selection:bg-blue-500 selection:text-white">
        
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <svg class="absolute left-[calc(50%-4rem)] top-10 -z-10 transform-gpu blur-3xl sm:left-[calc(50%-18rem)] lg:left-48 lg:top-[calc(50%-30rem)] xl:left-[calc(50%-24rem)]" aria-hidden="true">
                <div class="aspect-[1108/632] w-[69.25rem] bg-gradient-to-r from-blue-300 to-indigo-400 opacity-20" style="clip-path: polygon(73.6% 51.7%, 91.7% 11.8%, 100% 46.4%, 97.4% 82.2%, 92.5% 84.9%, 75.7% 64%, 55.3% 47.5%, 46.5% 49.4%, 45% 62.9%, 50.3% 87.2%, 21.3% 64.1%, 0.1% 100%, 5.4% 51.1%, 21.4% 63.9%, 58.9% 0.2%, 73.6% 51.7%)"></div>
            </svg>
        </div>

        <div class="max-w-4xl mx-auto p-6 text-center">
            <div class="flex justify-center mb-6">
                <div class="p-4 bg-blue-600 rounded-full shadow-xl animate-bounce">
                    <i class="fas fa-boxes text-white text-5xl"></i>
                </div>
            </div>
            
            <h1 class="text-5xl font-bold text-gray-900 tracking-tight mb-4">
                INVENTRA
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Sistem Manajemen Gudang Terintegrasi untuk efisiensi stok, transaksi, dan pelaporan bisnis Anda.
            </p>

            <div class="flex justify-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition transform hover:scale-105">
                            <i class="fas fa-tachometer-alt mr-2"></i> Masuk ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition transform hover:scale-105">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-gray-700 font-semibold rounded-lg shadow-md border border-gray-200 hover:bg-gray-50 transition transform hover:scale-105">
                                Daftar Supplier
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>

        <div class="absolute bottom-6 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} Inventra Warehouse System. All rights reserved.
        </div>
    </div>

</body>
</html>