<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="mb-6 text-center">
                <a href="/" class="flex flex-col items-center gap-2 group">
                    <div class="p-3 bg-blue-600 rounded-full shadow-lg group-hover:bg-blue-700 transition">
                        <i class="fas fa-boxes text-white text-3xl"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800 tracking-wider group-hover:text-blue-600 transition">INVENTRA</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg border-t-4 border-blue-600">
                {{ $slot }}
            </div>

            <div class="mt-8 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} Inventra Warehouse System.
            </div>
        </div>
    </body>
</html>