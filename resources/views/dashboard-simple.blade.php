<x-app-simple-layout>
    <div class="flex-1 flex flex-col items-center justify-center px-6 py-12 min-h-[calc(100vh-8rem)]">
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
    </div>
</x-app-simple-layout>
