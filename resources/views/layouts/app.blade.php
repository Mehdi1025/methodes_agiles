<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
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
        <div class="flex h-screen bg-gray-50 dark:bg-zinc-950 overflow-hidden transition-colors duration-300">
            <!-- Sidebar fixe (gauche) -->
            <aside class="w-64 shrink-0 flex flex-col bg-slate-900 dark:bg-zinc-950 text-white border-r border-slate-700/50 dark:border-zinc-800 transition-colors duration-300">
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
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('colis.index') ? 'bg-slate-800 text-teal-400' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    Colis
                                </a>
                                <a href="{{ route('magasinier.colis.scanner') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('magasinier.colis.*') ? 'bg-slate-800 text-teal-400' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                    Smart Scanner
                                </a>
                                <a href="{{ route('clients.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('clients.*') ? 'bg-slate-800 text-teal-400' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Clients
                                </a>
                                <a href="{{ route('magasinier.expeditions.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('magasinier.expeditions.*') ? 'bg-slate-800 text-teal-400 border-l-2 border-indigo-500 -ml-0.5 pl-[15px]' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                    </svg>
                                    <span class="font-medium">Quais d'Expédition</span>
                                </a>
                                <a href="{{ route('magasinier.picking.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('magasinier.picking.*') ? 'bg-slate-800 text-teal-400' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    Pick & Pack
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
                <header class="h-16 shrink-0 bg-white dark:bg-zinc-900 shadow-sm flex items-center justify-between px-6 gap-4 border-b border-gray-100 dark:border-zinc-800 transition-colors duration-300">
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        @if(auth()->user()->role !== 'admin')
                        <button type="button" onclick="openCommandPalette()" class="flex items-center gap-3 flex-1 max-w-xl px-4 py-2.5 text-left bg-zinc-50 dark:bg-zinc-800/50 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl border border-zinc-200/80 dark:border-zinc-700 transition-all group">
                            <svg class="w-4 h-4 text-zinc-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span class="text-zinc-500 dark:text-zinc-400 text-sm truncate flex-1">Rechercher ou lancer une commande...</span>
                            <kbd class="hidden sm:flex items-center gap-0.5 px-1.5 py-0.5 bg-zinc-200 dark:bg-zinc-700 text-[10px] font-sans text-zinc-500 dark:text-zinc-400 rounded border border-zinc-300 dark:border-zinc-600">Ctrl</kbd>
                            <kbd class="hidden sm:flex items-center justify-center min-w-[18px] h-5 px-1 bg-zinc-200 dark:bg-zinc-700 text-[10px] font-sans text-zinc-500 dark:text-zinc-400 rounded border border-zinc-300 dark:border-zinc-600">K</kbd>
                        </button>
                        @endif
                        <span class="text-gray-600 dark:text-zinc-400 shrink-0">Bienvenue,</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
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
                <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-zinc-950 transition-colors duration-300">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @if(auth()->user()->role !== 'admin')
        {{-- Bouton flottant Command Palette (bas droite) --}}
        <div class="fixed bottom-6 right-6 z-40 hidden md:block">
            <button type="button" onclick="openCommandPalette()" class="command-palette-trigger flex items-center gap-3 px-3 py-2 bg-zinc-900/50 dark:bg-zinc-900/80 backdrop-blur-md border border-white/10 rounded-xl hover:bg-zinc-800/90 transition-all duration-300 group shadow-2xl max-w-[95px] hover:max-w-[320px] overflow-hidden" title="Rechercher ou lancer une commande... (Ctrl+K)">
                <div class="flex items-center gap-1.5 shrink-0">
                    <kbd class="min-w-[20px] h-5 flex items-center justify-center bg-zinc-700 text-[10px] font-sans text-zinc-300 rounded border border-zinc-500 shadow-sm">Ctrl</kbd>
                    <span class="text-zinc-500 text-xs">+</span>
                    <kbd class="min-w-[20px] h-5 flex items-center justify-center bg-zinc-700 text-[10px] font-sans text-zinc-300 rounded border border-zinc-500 shadow-sm">K</kbd>
                </div>
                <div class="h-4 w-[1px] bg-white/10 shrink-0"></div>
                <span class="text-xs font-medium text-zinc-400 group-hover:text-zinc-100 transition-colors whitespace-nowrap min-w-0 overflow-hidden opacity-0 group-hover:opacity-100 transition-opacity duration-300">Rechercher ou lancer une commande...</span>
            </button>
        </div>
        {{-- Barre de Commande Magique (Command Palette) - Magasinier uniquement --}}
        <div id="command-palette-backdrop" class="fixed inset-0 z-40 hidden opacity-0 bg-black/40 backdrop-blur-md transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)]"></div>
        <div id="command-palette" class="fixed inset-0 z-50 flex items-start justify-center pt-[12vh] px-4 hidden opacity-0 transition-opacity duration-300 ease-[cubic-bezier(0.32,0.72,0,1)] pointer-events-none" style="transition-property: opacity;">
            <div id="command-palette-content" class="w-full max-w-2xl backdrop-blur-xl bg-zinc-900/80 border border-white/10 rounded-2xl shadow-[0_0_50px_-12px_rgba(0,0,0,0.5)] overflow-hidden transform transition-all duration-300 ease-[cubic-bezier(0.32,0.72,0,1)] scale-95 origin-top pointer-events-auto" style="transition-property: transform, opacity;">
                <div class="p-4 border-b border-white/5">
                    <input type="text"
                           id="command-palette-input"
                           class="w-full bg-transparent text-white text-xl font-medium placeholder-zinc-500 border-none outline-none focus:ring-0"
                           placeholder="Tapez une commande ou une référence..."
                           autocomplete="off"
                           spellcheck="false">
                </div>
                <div id="command-palette-results" class="max-h-[min(60vh,400px)] overflow-y-auto py-2">
                    {{-- Résultats injectés par JS --}}
                </div>
                <div class="px-4 py-2 border-t border-white/5 flex items-center justify-between text-xs text-zinc-500">
                    <span>↑↓ Naviguer</span>
                    <span>↵ Valider</span>
                    <span>Esc Fermer</span>
                </div>
            </div>
        </div>

        <script>
            (function() {
                const palette = document.getElementById('command-palette');
                const backdrop = document.getElementById('command-palette-backdrop');
                const input = document.getElementById('command-palette-input');
                const resultsContainer = document.getElementById('command-palette-results');
                const content = document.getElementById('command-palette-content');

                const baseActions = [
                    { id: 'scan', label: 'Nouveau Scan', icon: '📦', url: @json(route('magasinier.colis.scanner')), keywords: 'scan scanner réception' },
                    { id: 'quais', label: 'Voir les Quais', icon: '🚚', url: @json(route('magasinier.expeditions.index')), keywords: 'quais expédition transport' },
                    { id: 'picking', label: 'Mission Picking', icon: '📋', url: @json(route('magasinier.picking.index')), keywords: 'picking mission préparation' },
                    { id: 'theme', label: 'Mode Nuit', icon: '🌙', action: 'toggleTheme', keywords: 'nuit dark thème' },
                    { id: 'search', label: 'Chercher un colis...', icon: '🔍', action: 'searchColis', keywords: 'chercher colis recherche' }
                ];

                const colisIndexUrl = @json(route('colis.index'));

                function getFilteredActions(query) {
                    const q = (query || '').trim().toLowerCase();
                    let actions = [...baseActions];

                    if (q.length >= 2) {
                        actions.unshift({
                            id: 'search-ref',
                            label: `Chercher "${q}"`,
                            icon: '🔍',
                            url: colisIndexUrl + '?q=' + encodeURIComponent(q),
                            keywords: q
                        });
                    }

                    if (!q) return actions;
                    return actions.filter(a => {
                        const text = (a.label + ' ' + (a.keywords || '')).toLowerCase();
                        return text.includes(q);
                    });
                }

                function renderResults(actions, selectedIndex = 0) {
                    resultsContainer.innerHTML = actions.map((action, i) => {
                        const isSelected = i === selectedIndex;
                        const url = action.url || '#';
                        const clickHandler = action.action
                            ? `onclick="event.preventDefault(); runAction('${action.action}'); closeCommandPalette();"`
                            : `onclick="closeCommandPalette();"`;
                        return `
                            <a href="${url}" ${clickHandler} data-index="${i}"
                               class="command-item flex items-center gap-4 px-4 py-3 text-left transition-colors cursor-pointer ${isSelected ? 'bg-white/10 text-white' : 'text-zinc-300 hover:bg-white/5'}">
                                <span class="text-2xl">${action.icon}</span>
                                <span class="font-medium">${action.label}</span>
                            </a>
                        `;
                    }).join('');
                }

                function runAction(actionName) {
                    if (actionName === 'toggleTheme') {
                        const html = document.documentElement;
                        const isDark = html.classList.toggle('dark');
                        localStorage.setItem('theme', isDark ? 'dark' : 'light');
                    } else if (actionName === 'searchColis') {
                        window.location.href = colisIndexUrl;
                    }
                }

                function openCommandPalette() {
                    backdrop.classList.remove('hidden');
                    palette.classList.remove('hidden', 'pointer-events-none');
                    input.value = '';
                    input.focus();
                    updateResults();
                    requestAnimationFrame(() => {
                        backdrop.classList.remove('opacity-0');
                        palette.classList.remove('opacity-0');
                        content.classList.remove('scale-95');
                        content.classList.add('scale-100');
                    });
                }

                function closeCommandPalette() {
                    backdrop.classList.add('opacity-0');
                    palette.classList.add('opacity-0');
                    content.classList.remove('scale-100');
                    content.classList.add('scale-95');
                    setTimeout(() => {
                        backdrop.classList.add('hidden');
                        palette.classList.add('hidden', 'pointer-events-none');
                    }, 250);
                }

                let selectedIndex = 0;
                let currentActions = [];

                function updateResults() {
                    currentActions = getFilteredActions(input.value);
                    selectedIndex = Math.min(selectedIndex, Math.max(0, currentActions.length - 1));
                    renderResults(currentActions, selectedIndex);
                    const selected = resultsContainer.querySelector('.command-item[data-index="' + selectedIndex + '"]');
                    if (selected) selected.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                }

                input.addEventListener('input', () => { selectedIndex = 0; updateResults(); });
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowDown') { e.preventDefault(); selectedIndex = Math.min(selectedIndex + 1, currentActions.length - 1); updateResults(); }
                    else if (e.key === 'ArrowUp') { e.preventDefault(); selectedIndex = Math.max(selectedIndex - 1, 0); updateResults(); }
                    else if (e.key === 'Enter') {
                        e.preventDefault();
                        const action = currentActions[selectedIndex];
                        if (action) {
                            closeCommandPalette();
                            if (action.action) runAction(action.action);
                            else if (action.url) window.location.href = action.url;
                        }
                    }
                });

                palette.addEventListener('click', (e) => { if (e.target === palette) closeCommandPalette(); });
                backdrop.addEventListener('click', closeCommandPalette);

                document.addEventListener('keydown', (e) => {
                    if ((e.metaKey || e.ctrlKey) && e.key === 'k') { e.preventDefault(); openCommandPalette(); }
                    if (e.key === 'Escape') closeCommandPalette();
                });

                window.openCommandPalette = openCommandPalette;
                window.closeCommandPalette = closeCommandPalette;

                if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');
            })();
        </script>
        @endif
    </body>
</html>
