<x-app-layout>
    <div class="min-h-full -m-6 bg-gradient-to-b from-slate-50 via-white to-slate-50">
        <div class="p-6 lg:p-8 space-y-8">
        @if (session('success'))
            <div class="flex items-center gap-3 rounded-2xl border border-emerald-200/80 bg-emerald-50/90 backdrop-blur-sm p-4 text-emerald-800 shadow-sm">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">
                {{ session('error') }}
            </div>
        @endif

        {{-- Toggle Mode --}}
        <div class="kiosk-hide flex justify-end">
            <div class="inline-flex rounded-xl bg-slate-100/80 p-1 shadow-inner">
                <button type="button" onclick="switchDashboardMode('standard')" id="btn-mode-standard"
                    class="rounded-lg px-4 py-2 text-sm font-medium text-slate-500 transition-all duration-200 hover:text-slate-700">🎓 École</button>
                <button type="button" onclick="switchDashboardMode('advanced')" id="btn-mode-advanced"
                    class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-indigo-600 shadow-sm ring-1 ring-slate-200/50 transition-all duration-200">🚀 Pro</button>
            </div>
        </div>

        {{-- Mode Avancé (Pro) --}}
        <div id="dashboard-advanced" class="block transition-opacity duration-300">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
        <div class="lg:col-span-3 space-y-8">
        {{-- En-tête Vue Globale --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Vue Globale</h1>
                <p class="mt-2 text-slate-500">Supervision de l'entrepôt et activité en temps réel</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <button type="button" onclick="toggleKioskMode()"
                    class="kiosk-hide inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white shadow-lg shadow-slate-900/20 transition-all hover:bg-slate-800 hover:shadow-xl active:scale-[0.98]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Mode Écran Géant
                </button>
                <a href="{{ route('admin.equipe.index') }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-all hover:border-indigo-200 hover:bg-indigo-50/50 hover:text-indigo-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Gérer l'équipe
                </a>
            </div>
        </div>

        {{-- Bento : Santé Système --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="group relative flex min-h-[220px] flex-col justify-between overflow-hidden rounded-2xl border border-slate-200/80 bg-gradient-to-br from-slate-900 to-slate-950 p-6 shadow-xl shadow-slate-900/10 ring-1 ring-slate-800/50 transition-all hover:shadow-2xl hover:ring-slate-700/50">
                <div class="absolute -top-12 -right-12 h-40 w-40 rounded-full bg-emerald-500/20 blur-3xl"></div>
                <div>
                    <div class="mb-3 flex items-center gap-2">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-500/20">
                            <svg class="h-4 w-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-widest text-zinc-500">System Core</span>
                    </div>
                    <p class="text-4xl font-black tracking-tighter text-emerald-400">ONLINE</p>
                </div>
                <div class="relative mt-6 flex flex-col gap-2.5">
                    <div class="flex items-center gap-3 rounded-lg bg-white/5 px-3 py-2">
                        <span class="h-2 w-2 shrink-0 animate-pulse rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]"></span>
                        <span class="text-sm text-zinc-300">Base de données</span>
                    </div>
                    <div class="flex items-center gap-3 rounded-lg bg-white/5 px-3 py-2">
                        <span class="h-2 w-2 shrink-0 animate-pulse rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]"></span>
                        <span class="text-sm text-zinc-300">IA Mistral</span>
                    </div>
                    <div class="flex items-center gap-3 rounded-lg bg-white/5 px-3 py-2">
                        <span class="h-2 w-2 shrink-0 animate-pulse rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]"></span>
                        <span class="text-sm text-zinc-300">Cache</span>
                    </div>
                </div>
            </div>
            {{-- Bloc 2 : Aperçu rapide --}}
            <div class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm ring-1 ring-slate-200/50 transition-all hover:shadow-lg hover:ring-slate-300/50">
                <div class="absolute top-0 right-0 h-24 w-24 rounded-full bg-indigo-100/80 blur-2xl"></div>
                <div class="relative">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Aperçu</h3>
                    <p class="mt-4 text-3xl font-bold text-slate-900">{{ number_format($kpis['colis'] ?? 0, 0, ',', ' ') }}</p>
                    <p class="text-sm text-slate-500">colis au total</p>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium {{ ($kpis['anomalies'] ?? 0) > 0 ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                            {{ ($kpis['anomalies'] ?? 0) > 0 ? '⚠️ ' . $kpis['anomalies'] . ' alerte(s)' : '✓ Tout va bien' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- KPIs Système --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="group rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm ring-1 ring-slate-200/30 transition-all hover:shadow-md hover:ring-slate-300/50">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 transition-colors group-hover:bg-indigo-100">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-500">Employés</p>
                        <p class="text-2xl font-bold tracking-tight text-slate-900">{{ $kpis['utilisateurs'] }}</p>
                    </div>
                </div>
            </div>

            <div class="group rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm ring-1 ring-slate-200/30 transition-all hover:shadow-md hover:ring-slate-300/50">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-600 transition-colors group-hover:bg-slate-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-500">Volume</p>
                        <p class="text-2xl font-bold tracking-tight text-slate-900">{{ number_format($kpis['colis'], 0, ',', ' ') }}</p>
                        <p class="text-xs text-slate-400">colis</p>
                    </div>
                </div>
            </div>

            <div class="group rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm ring-1 ring-slate-200/30 transition-all hover:shadow-md hover:ring-slate-300/50">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl {{ $kpis['anomalies'] > 0 ? 'bg-rose-50 text-rose-600' : 'bg-slate-100 text-slate-600' }} transition-colors group-hover:{{ $kpis['anomalies'] > 0 ? 'bg-rose-100' : 'bg-slate-200' }}">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-500">Alertes</p>
                        <p class="text-2xl font-bold tracking-tight {{ $kpis['anomalies'] > 0 ? 'text-rose-600' : 'text-slate-900' }}">{{ $kpis['anomalies'] }}</p>
                        <p class="text-xs text-slate-400">Retards / Retours</p>
                    </div>
                </div>
            </div>

            <div class="group rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm ring-1 ring-slate-200/30 transition-all hover:shadow-md hover:ring-emerald-200/50">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition-colors group-hover:bg-emerald-100">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-500">Serveur</p>
                        <span class="inline-flex items-center gap-1 rounded-lg bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">En ligne</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Journal d'Audit + Leaderboard + Moniteur --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
            {{-- Journal d'Audit --}}
            <div class="lg:col-span-2 overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm ring-1 ring-slate-200/30 transition-shadow hover:shadow-md">
                <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                    <h3 class="font-semibold tracking-tight text-slate-900">Journal d'Audit en Temps Réel</h3>
                    <p class="mt-0.5 text-sm text-slate-500">Dernières actions enregistrées sur la plateforme</p>
                </div>
                <div class="p-6">
                    <div class="relative">
                        <div class="absolute left-[11px] top-2 bottom-2 w-0.5 rounded-full bg-gradient-to-b from-indigo-200 via-slate-200 to-slate-200"></div>
                        <div class="space-y-0">
                            @forelse($auditLogs as $log)
                                <div class="group relative flex gap-4 pb-6 last:pb-0">
                                    <div class="relative z-10 mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-white bg-slate-100 shadow-sm ring-2 ring-slate-200/50">
                                        <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm leading-relaxed text-slate-700">
                                            <span class="text-slate-400">{{ $log->date_mouvement?->diffForHumans() ?? '—' }}</span>
                                            — <span class="font-medium text-slate-900">{{ $log->user?->name ?? 'N/A' }}</span>
                                            a passé le colis
                                            @if($log->colis && $log->colis_id)
                                                <a href="{{ route('colis.show', $log->colis_id) }}" class="font-mono text-indigo-600 underline-offset-2 hover:underline">{{ Str::limit($log->colis->code_qr ?? $log->colis->id, 12) }}</a>
                                            @else
                                                <span class="font-mono text-slate-500">—</span>
                                            @endif
                                            en statut <span class="inline-flex rounded-md bg-slate-100 px-1.5 py-0.5 font-medium text-slate-800">{{ $log->nouveau_statut }}</span>
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-200 bg-slate-50/50 py-12">
                                    <svg class="h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    <p class="mt-3 text-sm font-medium text-slate-500">Aucun mouvement enregistré</p>
                                    <p class="text-xs text-slate-400">Les actions apparaîtront ici en temps réel</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Top Magasiniers du Jour --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm ring-1 ring-slate-200/30 transition-shadow hover:shadow-md">
                <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                    <h3 class="flex items-center gap-2 font-semibold tracking-tight text-slate-900">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 text-amber-600">🏆</span>
                        Top Magasiniers du Jour
                    </h3>
                    <p class="mt-0.5 text-sm text-slate-500">Basé sur les mouvements d'aujourd'hui</p>
                </div>
                <div class="p-6">
                    @if($topMagasiniers->isEmpty())
                        <div class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-200 bg-slate-50/50 py-10">
                            <svg class="h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <p class="mt-2 text-sm font-medium text-slate-500">Aucune activité aujourd'hui</p>
                        </div>
                    @else
                        <div class="flex flex-col gap-2">
                            @foreach($topMagasiniers as $magasinier)
                                <div class="group flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50/50 p-3 transition-colors hover:bg-slate-100/80">
                                    <div class="flex items-center gap-3">
                                        @if($loop->iteration == 1)
                                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-amber-100 text-sm font-bold text-amber-700 shadow-sm">1</span>
                                        @elseif($loop->iteration == 2)
                                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-200 text-sm font-bold text-slate-700">2</span>
                                        @elseif($loop->iteration == 3)
                                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-orange-100 text-sm font-bold text-orange-700">3</span>
                                        @else
                                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-sm font-medium text-slate-600">{{ $loop->iteration }}</span>
                                        @endif
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center overflow-hidden rounded-full bg-indigo-100 text-sm font-semibold text-indigo-600">
                                            {{ strtoupper(mb_substr($magasinier->user?->name ?? '?', 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-slate-900">{{ $magasinier->user?->name ?? 'N/A' }}</span>
                                    </div>
                                    <span class="rounded-full bg-slate-200/80 px-2.5 py-1 text-xs font-semibold text-slate-700">{{ $magasinier->total_mouvements }} actions</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Moniteur Infrastructure --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm ring-1 ring-slate-200/30 transition-shadow hover:shadow-md">
                <div class="mb-4 flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100">
                        <svg class="h-5 w-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m2-6h2m2 6h2M5 19h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">Infrastructure</h3>
                        <p class="text-xs text-slate-500">Santé des services</p>
                    </div>
                </div>
                <div class="space-y-2.5">
                    <div class="flex items-center gap-3 rounded-lg bg-emerald-50/80 px-3 py-2.5">
                        <span class="h-2 w-2 shrink-0 animate-pulse rounded-full bg-emerald-500 shadow-[0_0_6px_rgba(16,185,129,0.6)]"></span>
                        <span class="text-sm text-slate-700">Base de données <strong class="text-emerald-700">{{ $systemStatus['database'] }}</strong></span>
                    </div>
                    <div class="flex items-center gap-3 rounded-lg bg-emerald-50/80 px-3 py-2.5">
                        <span class="h-2 w-2 shrink-0 animate-pulse rounded-full bg-emerald-500 shadow-[0_0_6px_rgba(16,185,129,0.6)]"></span>
                        <span class="text-sm text-slate-700">Mistral AI <strong class="text-emerald-700">{{ $systemStatus['ai_mistral'] }}</strong></span>
                    </div>
                    <div class="flex items-center gap-3 rounded-lg bg-slate-50 px-3 py-2.5">
                        <span class="h-2 w-2 shrink-0 rounded-full bg-slate-400"></span>
                        <span class="text-sm text-slate-600">PHP <strong>{{ $systemStatus['php_version'] }}</strong> · Laravel <strong>{{ $systemStatus['laravel_version'] }}</strong></span>
                    </div>
                </div>
                <form action="{{ route('admin.clear-cache') }}" method="POST" class="mt-5">
                    @csrf
                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-medium text-slate-700 transition-all hover:bg-slate-100 hover:border-slate-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Optimiser & Vider le cache
                    </button>
                </form>
            </div>
        </div>

        </div>{{-- /lg:col-span-3 --}}

        {{-- Colonne latérale : Flux d'Activité Live --}}
        <div class="lg:col-span-1">
            <div id="activity-feed-container" class="sticky top-6 overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-lg ring-1 ring-slate-200/30 transition-shadow hover:shadow-xl">
                <div class="flex items-center justify-between border-b border-slate-200 bg-zinc-900 px-4 py-3">
                    <h3 class="font-semibold text-white">Flux d'activité</h3>
                    <span class="inline-flex items-center gap-1.5 rounded bg-red-500/20 px-2 py-0.5">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-500 opacity-75"></span>
                            <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-red-500"></span>
                        </span>
                        <span class="text-xs font-medium text-red-400">LIVE</span>
                    </span>
                </div>
                <div id="activity-feed-list" class="max-h-[calc(100vh-12rem)] overflow-y-auto divide-y divide-slate-100">
                    @include('admin.partials.activity-feed', ['activityFeed' => $activityFeed])
                </div>
            </div>
        </div>
        </div>{{-- /grid lg:grid-cols-4 --}}

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
        </div>{{-- /#dashboard-advanced --}}

        {{-- Mode Standard (Cahier des charges école) --}}
        <div id="dashboard-standard" class="hidden transition-opacity duration-300">
            <h2 class="mb-6 text-xl font-semibold text-slate-900">Tableau de bord administrateur</h2>
            <div class="mb-6 grid grid-cols-2 gap-4">
                <div class="rounded border border-slate-200 bg-white p-4">
                    <p class="text-sm text-slate-600">Total Colis</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ number_format($kpis['colis'] ?? 0, 0, ',', ' ') }}</p>
                </div>
                <div class="rounded border border-slate-200 bg-white p-4">
                    <p class="text-sm text-slate-600">Anomalies</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $kpis['anomalies'] ?? 0 }}</p>
                </div>
            </div>
            <div class="rounded border border-slate-200 bg-white">
                <h3 class="border-b border-slate-200 px-4 py-3 text-sm font-semibold text-slate-900">Derniers mouvements</h3>
                <table class="w-full table-auto border-collapse text-left">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50">
                            <th class="px-4 py-2 text-sm font-medium text-slate-700">Date</th>
                            <th class="px-4 py-2 text-sm font-medium text-slate-700">Utilisateur</th>
                            <th class="px-4 py-2 text-sm font-medium text-slate-700">Colis</th>
                            <th class="px-4 py-2 text-sm font-medium text-slate-700">Nouveau statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auditLogs->take(5) as $log)
                            <tr class="border-b border-slate-100">
                                <td class="px-4 py-2 text-sm text-slate-900">{{ $log->date_mouvement?->format('d/m/Y H:i') ?? '—' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-900">{{ $log->user?->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-900">{{ $log->colis ? ($log->colis->code_qr ?? $log->colis->id) : '—' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-900">{{ $log->nouveau_statut }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500">Aucun mouvement enregistré.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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

        function switchDashboardMode(mode) {
            const advContainer = document.getElementById('dashboard-advanced');
            const stdContainer = document.getElementById('dashboard-standard');
            const btnAdv = document.getElementById('btn-mode-advanced');
            const btnStd = document.getElementById('btn-mode-standard');

            if (mode === 'standard') {
                advContainer.classList.add('hidden');
                stdContainer.classList.remove('hidden');
                btnStd.classList.add('bg-white', 'text-slate-900', 'shadow-sm', 'ring-1', 'ring-slate-900/5');
                btnStd.classList.remove('text-slate-500', 'hover:text-slate-700');
                btnAdv.classList.remove('bg-white', 'text-indigo-600', 'shadow-sm', 'ring-1', 'ring-slate-900/5');
                btnAdv.classList.add('text-slate-500', 'hover:text-slate-700');
            } else {
                stdContainer.classList.add('hidden');
                advContainer.classList.remove('hidden');
                btnAdv.classList.add('bg-white', 'text-indigo-600', 'shadow-sm', 'ring-1', 'ring-slate-900/5');
                btnAdv.classList.remove('text-slate-500', 'hover:text-slate-700');
                btnStd.classList.remove('bg-white', 'text-slate-900', 'shadow-sm', 'ring-1', 'ring-slate-900/5');
                btnStd.classList.add('text-slate-500', 'hover:text-slate-700');
            }
            localStorage.setItem('dashboardMode', mode);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const savedMode = localStorage.getItem('dashboardMode') || 'advanced';
            switchDashboardMode(savedMode);

            // Rafraîchissement du flux d'activité toutes les 30 secondes
            const feedContainer = document.getElementById('activity-feed-list');
            if (feedContainer) {
                setInterval(async () => {
                    try {
                        const res = await fetch('{{ route("admin.dashboard.activity-feed") }}', {
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
                        });
                        if (res.ok) {
                            const html = await res.text();
                            feedContainer.innerHTML = html;
                        }
                    } catch (e) { /* ignore */ }
                }, 30000);
            }
        });
    </script>
</x-app-layout>
