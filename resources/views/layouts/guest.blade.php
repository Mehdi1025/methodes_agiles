<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-100">
            <div class="w-full sm:max-w-md">
                <h1 class="text-2xl font-bold text-center text-gray-800 mb-2">
                    📦 Gestionnaire de Colis
                </h1>
                <p class="text-center text-sm text-gray-500 mb-8">
                    Système de gestion logistique
                </p>

                <div class="bg-white rounded-xl shadow-lg shadow-gray-200/50 px-8 py-10 border border-gray-100">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
