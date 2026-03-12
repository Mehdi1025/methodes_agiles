<x-app-layout>
    <div class="space-y-6 bg-zinc-50 min-h-full -m-6 p-6">
        @if (session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-emerald-700 shadow-sm">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">
                {{ session('error') }}
            </div>
        @endif

        <!-- 1. En-tête Vue Globale -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Vue Globale</h1>
                <p class="mt-1 text-sm text-slate-500">Supervision de l'entrepôt et activité en temps réel</p>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="toggleKioskMode()"
                    class="kiosk-hide ml-auto flex items-center gap-2 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white shadow-sm ring-1 ring-zinc-700/50 transition-colors hover:bg-zinc-800">
                    📺 Mode Écran Géant
                </button>
                <a href="{{ route('admin.equipe.index') }}"
                   class="inline-flex h-10 items-center gap-2 rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-900 transition-colors hover:bg-slate-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Gérer l'équipe
            </a>
            </div>
        </div>

        <!-- 2. Bento Grid -->
        <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-3">
            {{-- Bloc 1 : Santé du Système --}}
            <div class="relative flex min-h-[250px] flex-col justify-between overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-950 p-6 shadow-xl">
                <div class="absolute top-0 right-0 h-32 w-32 rounded-full bg-emerald-500/10 blur-3xl"></div>
                <div>
                    <div class="mb-4 flex items-center gap-2">
                        <svg class="h-5 w-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                        </svg>
                        <span class="text-sm font-medium uppercase tracking-widest text-zinc-400">System Core</span>
                    </div>
                    <p class="text-4xl font-black tracking-tighter text-emerald-400">ONLINE</p>
                </div>
                <div class="relative mt-6 flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <span class="h-2 w-2 shrink-0 animate-pulse rounded-full bg-emerald-500"></span>
                        <span class="text-sm text-zinc-400">Base de données</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="h-2 w-2 shrink-0 animate-pulse rounded-full bg-emerald-500"></span>
                        <span class="text-sm text-zinc-400">IA Mistral</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="h-2 w-2 shrink-0 animate-pulse rounded-full bg-emerald-500"></span>
                        <span class="text-sm text-zinc-400">Cache</span>
                    </div>
                </div>
            </div>

            {{-- Bloc 2 : Live Activity Ticker --}}
            <div class="relative min-h-[250px] overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900 p-6 shadow-xl md:col-span-2">
                <div class="absolute top-0 left-0 h-px w-full bg-gradient-to-r from-transparent via-indigo-500 to-transparent"></div>
                <div class="flex items-center gap-2">
                    <h3 class="font-semibold text-zinc-100">Flux en Temps Réel</h3>
                    <span class="inline-flex items-center gap-1.5 rounded bg-red-500/20 px-2 py-0.5">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-500 opacity-75"></span>
                            <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-red-500"></span>
                        </span>
                        <span class="text-xs font-medium text-red-400">Live</span>
                    </span>
                </div>
                <div class="relative mt-4 h-[150px] overflow-hidden">
                    <div class="flex flex-col">
                        <div class="flex items-center gap-4 border-b border-zinc-800/50 py-3">
                            <span class="font-mono text-sm text-zinc-400">Logistique 1 a scanné le colis</span>
                            <span class="font-mono text-sm text-zinc-100">#COL-892</span>
                        </div>
                        <div class="flex items-center gap-4 border-b border-zinc-800/50 py-3">
                            <span class="font-mono text-sm text-zinc-400">IA Mistral a optimisé la Zone B</span>
                        </div>
                        <div class="flex items-center gap-4 border-b border-zinc-800/50 py-3">
                            <span class="font-mono text-sm text-zinc-400">Logistique 2 a expédié</span>
                            <span class="font-mono text-sm text-zinc-100">#COL-1204</span>
                        </div>
                        <div class="flex items-center gap-4 border-b border-zinc-800/50 py-3">
                            <span class="font-mono text-sm text-zinc-400">Entrée stock détectée —</span>
                            <span class="font-mono text-sm text-zinc-100">#COL-2156</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. KPIs Système (4 cartes) -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-3">
                        <svg class="h-6 w-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Employés Actifs</p>
                        <p class="text-2xl font-semibold tracking-tight text-slate-900">{{ $kpis['utilisateurs'] }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-3">
                        <svg class="h-6 w-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Volume Global</p>
                        <p class="text-2xl font-semibold tracking-tight text-slate-900">{{ number_format($kpis['colis'], 0, ',', ' ') }}</p>
                        <p class="text-xs text-slate-500">colis gérés</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-3">
                        <svg class="h-6 w-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Alertes Critiques</p>
                        <p class="text-2xl font-semibold tracking-tight {{ $kpis['anomalies'] > 0 ? 'text-rose-600' : 'text-slate-900' }}">{{ $kpis['anomalies'] }}</p>
                        <p class="text-xs text-rose-600/80">Retards / Retours</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-3">
                        <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Santé Serveur</p>
                        <span class="inline-flex items-center gap-1.5 rounded-md bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700">
                            Base de données connectée, IA en ligne
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Journal d'Audit + Leaderboard + Moniteur -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
            <!-- Journal d'Audit (2/4) -->
            <div class="lg:col-span-2 rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h3 class="font-semibold tracking-tight text-slate-900">Journal d'Audit en Temps Réel</h3>
                    <p class="mt-0.5 text-sm text-slate-500">Dernières actions enregistrées sur la plateforme</p>
                </div>
                <div class="p-6">
                    <div class="relative">
                        <div class="absolute left-[7px] top-2 bottom-2 w-px bg-slate-200"></div>
                        <div class="space-y-0">
                            @forelse($auditLogs as $log)
                                <div class="relative flex gap-4 pb-6 last:pb-0">
                                    <div class="relative z-10 mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full border-2 border-slate-200 bg-white">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-slate-700">
                                            <span class="text-slate-500">{{ $log->date_mouvement?->diffForHumans() ?? '—' }}</span>
                                            : <span class="font-medium text-slate-900">{{ $log->user?->name ?? 'N/A' }}</span>
                                            a passé le colis <span class="font-mono text-slate-600">{{ $log->colis ? Str::limit($log->colis->code_qr ?? $log->colis->id, 10) : '—' }}</span>
                                            en statut <span class="font-medium text-slate-900">{{ $log->nouveau_statut }}</span>
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Aucun mouvement enregistré.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Magasiniers du Jour (1/4) -->
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h3 class="font-semibold tracking-tight text-slate-900">🏆 Top Magasiniers du Jour</h3>
                    <p class="mt-0.5 text-sm text-slate-500">Basé sur les mouvements de colis d'aujourd'hui</p>
                </div>
                <div class="p-6">
                    @if($topMagasiniers->isEmpty())
                        <p class="text-center text-sm text-slate-500">Aucune activité enregistrée aujourd'hui.</p>
                    @else
                        <div class="mt-4 flex flex-col gap-3">
                            @foreach($topMagasiniers as $magasinier)
                                <div class="flex items-center justify-between rounded-lg border border-slate-100 bg-slate-50 p-3">
                                    <div class="flex items-center gap-3">
                                        @if($loop->iteration == 1)
                                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100 text-sm font-bold text-amber-600">{{ $loop->iteration }}</span>
                                        @elseif($loop->iteration == 2)
                                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-200 text-sm font-bold text-slate-700">{{ $loop->iteration }}</span>
                                        @elseif($loop->iteration == 3)
                                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-orange-100 text-sm font-bold text-orange-700">{{ $loop->iteration }}</span>
                                        @else
                                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-200 text-sm font-medium text-slate-600">{{ $loop->iteration }}</span>
                                        @endif
                                        <span class="font-medium text-slate-900">{{ $magasinier->user?->name ?? 'N/A' }}</span>
                                    </div>
                                    <span class="text-sm text-slate-600">{{ $magasinier->total_mouvements }} <span class="text-slate-400">actions</span></span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Moniteur de Santé Système & IA (1/4) -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-1 flex items-center gap-2 text-lg font-semibold text-slate-900">🖥️ État de l'Infrastructure</h3>
                <p class="mb-4 text-sm text-slate-500">Santé du serveur et services associés</p>
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <span class="h-2 w-2 shrink-0 animate-pulse rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]"></span>
                        <span class="text-sm text-slate-700">Base de données : <strong>{{ $systemStatus['database'] }}</strong></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="h-2 w-2 shrink-0 animate-pulse rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]"></span>
                        <span class="text-sm text-slate-700">Mistral AI : <strong>{{ $systemStatus['ai_mistral'] }}</strong></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="h-2 w-2 shrink-0 rounded-full bg-slate-400"></span>
                        <span class="text-sm text-slate-700">PHP <strong>{{ $systemStatus['php_version'] }}</strong> · Laravel <strong>{{ $systemStatus['laravel_version'] }}</strong></span>
                    </div>
                </div>
                <form action="{{ route('admin.clear-cache') }}" method="POST" class="mt-5">
                    @csrf
                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-100">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Optimiser & Vider le cache
                    </button>
                </form>
            </div>
        </div>

        {{-- Ticker Kiosk (visible uniquement en mode Écran Géant) --}}
        <div id="kiosk-ticker" class="fixed bottom-0 left-0 z-[100] hidden w-full overflow-hidden whitespace-nowrap border-t border-zinc-800 bg-zinc-950 py-4 font-mono text-xl text-emerald-400">
            <div class="inline-block animate-[ticker_20s_linear_infinite] pl-[100%]">
                <span class="mx-4">🟢 SYSTÈME OPÉRATIONNEL</span> •
                <span class="mx-4">📦 {{ number_format($kpis['colis'] ?? 0, 0, ',', ' ') }} COLIS TRAITÉS</span> •
                <span class="mx-4">🚨 {{ $kpis['anomalies'] ?? 0 }} ANOMALIES DÉTECTÉES</span> •
                <span class="mx-4">🧠 IA MISTRAL EN LIGNE</span> •
                <span class="mx-4">⚡ LATENCE RÉSEAU : 12ms</span> •
                <span class="mx-4">🟢 PRÊT POUR L'EXPÉDITION</span>
            </div>
        </div>
    </div>

    <style>
        @keyframes ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }
        body.kiosk-active {
            background-color: #09090b !important;
            color: #f4f4f5 !important;
            overflow-y: auto;
        }
        body.kiosk-active .bg-gray-50 {
            background-color: transparent !important;
        }
        body.kiosk-active aside,
        body.kiosk-active nav,
        body.kiosk-active header,
        body.kiosk-active .kiosk-hide {
            display: none !important;
        }
        body.kiosk-active main {
            margin: 0 !important;
            padding: 3rem !important;
            max-width: 100% !important;
            width: 100% !important;
        }
        body.kiosk-active .bg-white {
            background-color: #18181b !important;
            border-color: #27272a !important;
            color: #f4f4f5 !important;
        }
        body.kiosk-active .bg-zinc-50 {
            background-color: transparent !important;
        }
        body.kiosk-active .bg-slate-50,
        body.kiosk-active .bg-slate-100,
        body.kiosk-active .bg-amber-100,
        body.kiosk-active .bg-orange-100,
        body.kiosk-active .bg-emerald-50,
        body.kiosk-active .bg-emerald-100 {
            background-color: #27272a !important;
        }
        body.kiosk-active .text-slate-500,
        body.kiosk-active .text-slate-600,
        body.kiosk-active .text-slate-700,
        body.kiosk-active .text-gray-600 {
            color: #a1a1aa !important;
        }
        body.kiosk-active .text-slate-900,
        body.kiosk-active .text-gray-900 {
            color: #f4f4f5 !important;
        }
        body.kiosk-active #kiosk-ticker {
            display: block !important;
        }
    </style>

    <script>
        function toggleKioskMode() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    console.log('Erreur Fullscreen:', err.message);
                });
                document.body.classList.add('kiosk-active');
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
                document.body.classList.remove('kiosk-active');
            }
        }
        document.addEventListener('fullscreenchange', () => {
            if (!document.fullscreenElement) {
                document.body.classList.remove('kiosk-active');
            }
        });
    </script>
</x-app-layout>
