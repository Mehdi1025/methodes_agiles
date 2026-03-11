<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex h-screen bg-gray-50 overflow-hidden">
            <!-- Sidebar fixe (gauche) -->
            <aside class="w-64 shrink-0 flex flex-col bg-slate-900 text-white">
                <div class="p-6 border-b border-slate-700/50">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <span class="text-2xl">📦</span>
                        <span class="font-bold text-lg tracking-tight">Gestion Colis</span>
                    </a>
                </div>

                <nav class="flex-1 p-4 overflow-y-auto space-y-6">
                    @if(auth()->user()->role === 'admin')
                        {{-- Menu Admin --}}
                        <div>
                            <p class="px-4 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Administration</p>
                            <a href="{{ route('dashboard') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-teal-400' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                Vue Globale
                            </a>
                        </div>
                        <div>
                            <p class="px-4 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Gestion</p>
                            <div class="space-y-0.5">
                                <a href="{{ route('admin.equipe.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.equipe.*') ? 'bg-slate-800 text-teal-400' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    👥 Gestion Équipe
                                </a>
                                <a href="{{ route('admin.emplacements.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.emplacements.*') ? 'bg-slate-800 text-teal-400' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    🏢 Entrepôts & Zones
                                </a>
                                <a href="{{ route('admin.parametres.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.parametres.*') ? 'bg-slate-800 text-teal-400' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    ⚙️ Paramètres Système
                                </a>
                            </div>
                        </div>
                    @else
                        {{-- Menu Logistique (menu actuel) --}}
                        <div>
                            <p class="px-4 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Navigation</p>
                            <a href="{{ route('dashboard') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-teal-400' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                Tableau de bord
                            </a>
                        </div>
                        <div>
                            <p class="px-4 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Gestion</p>
                            <div class="space-y-0.5">
                                <a href="{{ route('colis.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('colis.*') ? 'bg-slate-800 text-teal-400' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    Colis
                                </a>
                                <a href="{{ route('clients.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('clients.*') ? 'bg-slate-800 text-teal-400' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Clients
                                </a>
                                <a href="{{ route('transporteurs.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('transporteurs.*') ? 'bg-slate-800 text-teal-400' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                    Transporteurs
                                </a>
                            </div>
                        </div>
                        <div>
                            <p class="px-4 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Rapports & Analyses</p>
                            <a href="{{ route('statistiques.index') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('statistiques.*') ? 'bg-slate-800 text-teal-400' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Statistiques
                            </a>
                        </div>
                        <div>
                            <p class="px-4 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Intelligence</p>
                            <a href="{{ route('assistant.index') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('assistant.*') ? 'bg-slate-800 text-teal-400' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                <span class="flex items-center gap-1.5">
                                    Assistant IA
                                    <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    @endif
                </nav>
            </aside>

            <!-- Main Content (droite) -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                <!-- Header blanc -->
                <header class="h-16 shrink-0 bg-white shadow-sm flex items-center justify-between px-6">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-600">Bienvenue,</span>
                        <span class="font-semibold text-gray-900">{{ Auth::user()->name }}</span>
                        @if(auth()->user()->role === 'admin')
                            <span class="px-2 py-0.5 text-xs font-medium bg-indigo-100 text-indigo-700 rounded">Admin</span>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Déconnexion
                        </button>
                    </form>
                </header>

                <!-- Zone de contenu -->
                <main class="flex-1 overflow-y-auto p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
