<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventra - Smart Warehouse System</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,800&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .bg-grid-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .animate-fade-up {
            animation: fadeUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="antialiased bg-slate-900 text-white overflow-x-hidden flex flex-col min-h-screen">

    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-950 via-slate-900 to-black"></div>
        <div class="absolute inset-0 bg-grid-pattern opacity-20"></div>
        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-blue-600/30 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-purple-600/20 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s"></div>
    </div>

    <nav class="relative z-10 w-full p-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3 font-bold text-2xl tracking-wider">
                <i class="fas fa-boxes text-blue-400"></i> INVENTRA
            </div>
            @auth
            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-blue-300 hover:text-white transition">
                Ke Dashboard <i class="fas fa-arrow-right ml-1"></i>
            </a>
            @endauth
        </div>
    </nav>

    <main class="relative z-10 flex-grow flex flex-col justify-center items-center px-6 py-12 text-center">

        <div class="inline-block p-8 rounded-3xl bg-white/5 backdrop-blur-md border border-white/10 mb-10 shadow-2xl hover:bg-white/10 transition-all duration-500">
            <i class="fas fa-boxes text-8xl text-blue-400"></i>
        </div>

        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight leading-tight mb-6 animate-fade-up delay-100">
            Warehouse <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">Intelligence.</span>
        </h1>

        <p class="text-lg md:text-xl text-slate-400 leading-relaxed max-w-2xl mx-auto mb-10 animate-fade-up delay-200">
            Platform manajemen inventori terintegrasi untuk efisiensi operasional gudang Anda.
            Pantau stok, kelola transaksi, dan restock dalam satu ekosistem.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-up delay-300">
            @if (Route::has('login'))
            @auth
            <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-full shadow-lg shadow-blue-600/30 transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                <i class="fas fa-tachometer-alt"></i> Masuk Dashboard
            </a>
            @else
            <a href="{{ route('login') }}" class="px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-full shadow-lg shadow-blue-600/30 transition transform hover:-translate-y-1 flex items-center justify-center gap-2 w-full sm:w-auto">
                <i class="fas fa-sign-in-alt"></i> Login Akses Sistem
            </a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="px-8 py-4 glass-card hover:bg-white/10 text-white font-bold rounded-full transition transform hover:-translate-y-1 flex items-center justify-center gap-2 w-full sm:w-auto">
                <i class="fas fa-user-plus"></i> Daftar Supplier
            </a>
            @endif
            @endauth
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-20 w-full max-w-5xl animate-fade-up delay-300">
            <div class="glass-card p-6 rounded-2xl text-left">
                <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center mb-4 text-blue-400">
                    <i class="fas fa-chart-pie text-xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-2 text-white">Real-time Data</h3>
                <p class="text-sm text-slate-400">Pantau pergerakan stok dan nilai aset gudang secara langsung dan akurat.</p>
            </div>
            <div class="glass-card p-6 rounded-2xl text-left">
                <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center mb-4 text-green-400">
                    <i class="fas fa-shield-alt text-xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-2 text-white">Secure Access</h3>
                <p class="text-sm text-slate-400">Kontrol akses multi-role untuk Admin, Manager, Staff, dan Supplier.</p>
            </div>
            <div class="glass-card p-6 rounded-2xl text-left">
                <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center mb-4 text-purple-400">
                    <i class="fas fa-sync text-xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-2 text-white">Smart Restock</h3>
                <p class="text-sm text-slate-400">Alur persetujuan pemesanan barang yang terstruktur dan transparan.</p>
            </div>
        </div>

    </main>

    <footer class="relative z-10 py-8 text-center text-sm text-slate-600">
        &copy; {{ date('Y') }} Inventra Warehouse System. All rights reserved.
    </footer>

</body>

</html>