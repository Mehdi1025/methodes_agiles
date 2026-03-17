<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#1e293b">

        <title>{{ config('app.name', 'Laravel') }} — Mode Terrain</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .safe-bottom { padding-bottom: env(safe-area-inset-bottom, 0); }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-100 min-h-screen flex flex-col">
        <main class="flex-1 flex flex-col overflow-y-auto pb-24">
            {{ $slot }}
        </main>

        {{-- Bottom Navigation Bar (iOS/Android style) --}}
        <nav class="fixed bottom-0 left-0 right-0 h-20 bg-white border-t border-slate-200 shadow-[0_-4px_20px_rgba(0,0,0,0.08)] safe-bottom z-50">
            <div class="h-full flex items-center justify-around px-4 max-w-lg mx-auto">
                <a href="{{ route('magasinier.colis.scanner') }}"
                   class="flex flex-col items-center justify-center gap-1 min-w-[80px] py-2 rounded-xl active:bg-slate-100 transition-colors touch-manipulation">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                    <span class="text-sm font-semibold text-slate-700">Scanner</span>
                </a>
                <a href="{{ route('magasinier.colis.du-jour') }}"
                   class="flex flex-col items-center justify-center gap-1 min-w-[80px] py-2 rounded-xl active:bg-slate-100 transition-colors touch-manipulation">
                    <svg class="w-10 h-10 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="text-sm font-semibold text-slate-700">Colis du jour</span>
                </a>
                <a href="{{ route('mode.switch') }}?mode=advanced"
                   class="flex flex-col items-center justify-center gap-1 min-w-[80px] py-2 rounded-xl active:bg-slate-100 transition-colors touch-manipulation">
                    <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="text-sm font-semibold text-slate-600">Quitter le mode</span>
                </a>
            </div>
        </nav>
    </body>
</html>
