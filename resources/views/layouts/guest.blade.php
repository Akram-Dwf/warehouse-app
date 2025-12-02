<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        .bg-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        /* CONTAINER ANIMASI */
        .left-panel {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100vw;
            z-index: 30;
            animation: shrinkLeft 1s cubic-bezier(0.65, 0, 0.35, 1) forwards;
            animation-delay: 0.85s;
        }

        .right-panel {
            position: fixed;
            top: 0;
            right: 0;
            height: 100vh;
            width: 50vw;
            transform: translateX(100%);
            z-index: 40;
            animation: slideInFromRight 1s cubic-bezier(0.65, 0, 0.35, 1) forwards;
            animation-delay: 0.85s;
            box-shadow: -20px 0 60px rgba(0, 0, 0, 0.15);
        }

        /* ANIMASI LOGO & TEXT - FADE IN */
        .hero-content {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s cubic-bezier(0.25, 1, 0.5, 1) forwards;
            animation-delay: 0.3s;
        }

        /* KEYFRAMES */
        @keyframes shrinkLeft {
            to { width: 50vw; }
        }

        @keyframes slideInFromRight {
            to { transform: translateX(0); }
        }

        @keyframes fadeInUp {
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        @media (max-width: 1023px) {
            .left-panel {
                display: none;
            }
            .right-panel {
                position: relative;
                width: 100vw;
                transform: none;
                animation: none;
            }
        }

        @media (min-width: 1024px) {
            .curved-panel {
                border-top-left-radius: 3rem;
                border-bottom-left-radius: 3rem;
            }
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.05); }
        }

        .glow-orb {
            animation: pulse-glow 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="antialiased bg-slate-900 overflow-hidden">
    
    <div class="left-panel">
        <div class="h-full flex flex-col justify-center items-center text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-950 via-slate-900 to-black"></div>
            <div class="absolute inset-0 bg-pattern opacity-20"></div>
            
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-600/30 rounded-full blur-[120px] glow-orb"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-80 h-80 bg-purple-600/20 rounded-full blur-[100px] glow-orb" style="animation-delay: 2s;"></div>
            
            <div class="relative z-10 text-center px-8 hero-content">
                <div class="inline-block p-8 rounded-3xl bg-white/5 backdrop-blur-md border border-white/10 mb-10 shadow-2xl hover:bg-white/10 transition-all duration-500">
                    <i class="fas fa-boxes text-8xl text-blue-400"></i>
                </div>
                
                <h1 class="text-6xl font-extrabold mb-6 tracking-tight leading-tight">
                    Sistem Gudang <br> 
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-400 to-purple-400">
                        Terintegrasi
                    </span>
                </h1>
                
                <p class="text-lg text-slate-300 max-w-md mx-auto leading-relaxed mb-8">
                    Kelola inventaris, pantau transaksi, dan atur restock dalam satu dashboard yang efisien.
                </p>
                
                <div class="flex flex-wrap justify-center gap-3 mt-8">
                    <span class="px-4 py-2 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-sm font-medium backdrop-blur-sm">
                        <i class="fas fa-chart-line mr-2"></i>Real-time Analytics
                    </span>
                    <span class="px-4 py-2 rounded-full bg-purple-500/20 border border-purple-400/30 text-purple-300 text-sm font-medium backdrop-blur-sm">
                        <i class="fas fa-shield-alt mr-2"></i>Secure & Fast
                    </span>
                    <span class="px-4 py-2 rounded-full bg-cyan-500/20 border border-cyan-400/30 text-cyan-300 text-sm font-medium backdrop-blur-sm">
                        <i class="fas fa-mobile-alt mr-2"></i>Multi-platform
                    </span>
                </div>
            </div>

            <div class="absolute bottom-8 text-xs text-slate-500 z-10">
                <i class="fas fa-copyright mr-1"></i>{{ date('Y') }} Inventra System. All rights reserved.
            </div>
        </div>
    </div>

    <div class="right-panel bg-white curved-panel">
        <div class="h-full flex items-center justify-center overflow-y-auto">
            <div class="w-full max-w-lg p-8 lg:p-16">
                
                <div class="lg:hidden text-center mb-10">
                    <a href="/" class="inline-flex items-center gap-3 text-3xl font-extrabold text-blue-800 hover:text-blue-600 transition-colors">
                        <i class="fas fa-boxes"></i> INVENTRA
                    </a>
                </div>

                <div>
                    {{ $slot }}
                </div>

            </div>
        </div>
    </div>

</body>
</html>