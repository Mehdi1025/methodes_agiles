<x-app-simple-layout>
    <div class="flex-1 flex flex-col px-6 py-12 min-h-[calc(100vh-8rem)]">
        {{-- Bandeau Watchdog : Colis en souffrance --}}
        @if(($colisEnSouffrance ?? collect())->count() > 0)
            <div class="mb-6 rounded-xl bg-red-50 border-l-4 border-red-500 border border-red-200/80 p-4 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-100">
                            <svg class="h-5 w-5 text-red-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-red-900">
                                ⚠️ WATCHDOG : {{ $colisEnSouffrance->count() }} colis en souffrance
                            </p>
                            <p class="mt-0.5 text-sm text-red-700">Plus de 24h sans mouvement</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <details class="relative">
                            <summary class="cursor-pointer inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                                Agir — Sélectionner un colis
                            </summary>
                            <div class="absolute right-0 mt-2 w-72 max-h-64 overflow-y-auto rounded-xl border border-red-200 bg-white shadow-lg z-10 py-2">
                                @foreach($colisEnSouffrance as $c)
                                    <a href="{{ route('colis.show', $c) }}" class="flex items-center justify-between gap-3 px-4 py-2.5 hover:bg-red-50 transition-colors">
                                        <span class="font-mono text-sm text-slate-800">{{ $c->code_qr ?? Str::limit($c->id, 12) }}</span>
                                        <span class="text-xs text-red-600">Voir →</span>
                                    </a>
                                @endforeach
                            </div>
                        </details>
                        <a href="{{ route('colis.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-50">
                            Tous les colis
                        </a>
                    </div>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-green-800 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

    <div class="flex-1 flex flex-col items-center justify-center">
        {{-- Bouton GÉANT Scanner --}}
        <a href="{{ route('magasinier.colis.scanner') }}"
           class="w-full max-w-md flex flex-col items-center justify-center gap-6 p-12 rounded-3xl bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] shadow-[0_20px_60px_-15px_rgba(79,70,229,0.5)] transition-all duration-200 touch-manipulation">
            <div class="w-28 h-28 rounded-2xl bg-white/20 flex items-center justify-center">
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
            </div>
            <span class="text-2xl sm:text-3xl font-bold text-white uppercase tracking-wide text-center">
                Scanner un colis
            </span>
        </a>

        {{-- Carte Dernier colis scanné --}}
        <div class="w-full max-w-md mt-8 p-6 rounded-2xl bg-white shadow-sm border border-slate-200">
            <p class="text-lg font-semibold text-slate-600 mb-3">Dernier colis scanné</p>
            @if($lastColis)
                <p class="text-xl font-mono font-bold text-slate-900 mb-2 truncate">{{ $lastColis->code_qr ?? $lastColis->id }}</p>
                @php
                    $statutLabel = match($lastColis->statut) {
                        'livré' => '✅ LIVRÉ',
                        'en_expédition' => '🚚 EN EXPÉDITION',
                        'en_preparation' => '📦 EN PRÉPARATION',
                        'en_stock' => '📦 EN STOCK',
                        'reçu' => '📥 REÇU',
                        'retour' => '↩️ RETOUR',
                        'anomalie' => '⚠️ ANOMALIE',
                        default => strtoupper(str_replace('_', ' ', $lastColis->statut)),
                    };
                    $statutClass = match($lastColis->statut) {
                        'livré' => 'text-emerald-600',
                        'en_expédition', 'en_preparation' => 'text-amber-600',
                        default => 'text-slate-600',
                    };
                @endphp
                <p class="text-2xl sm:text-3xl font-bold {{ $statutClass }}">{{ $statutLabel }}</p>
                <a href="{{ route('colis.show', $lastColis) }}" class="mt-4 inline-block text-base font-medium text-indigo-600 hover:text-indigo-700">
                    Voir le détail →
                </a>
            @else
                <p class="text-xl text-slate-400">Aucun scan pour le moment</p>
            @endif
        </div>

        {{-- Bouton de test Watchdog (Dev) - toujours visible --}}
        <div class="mt-8 pt-6 border-t border-slate-200 w-full max-w-md">
            <a href="{{ route('test-watchdog') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-transparent px-3 py-2 text-xs font-medium text-slate-500 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-700 transition-colors">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Simuler une alerte (Dev)
            </a>
        </div>
    </div>
    </div>
</x-app-simple-layout>
