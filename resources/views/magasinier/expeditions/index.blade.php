<x-app-layout>
    <div class="space-y-8">
        {{-- En-tête --}}
        <header>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">
                🚛 Quais d'Expédition
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Gestion des enlèvements et remises aux transporteurs
            </p>
        </header>

        {{-- Messages flash --}}
        @if (session('success'))
            <div class="rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif
        @if (session('warning'))
            <div class="rounded-xl bg-amber-50 border border-amber-200 px-4 py-3 text-sm font-medium text-amber-800">
                {{ session('warning') }}
            </div>
        @endif

        {{-- Grille Bento des transporteurs --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($transporteurs as $transporteur)
                @php
                    $colisCount = $transporteur->colis->count();
                    $hasColis = $colisCount > 0;
                @endphp
                <article class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden flex flex-col justify-between min-h-[280px]">
                    {{-- Haut de la carte --}}
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 truncate" title="{{ $transporteur->nom }}">
                            {{ $transporteur->nom }}
                        </h2>
                        <div class="mt-2">
                            @if ($hasColis)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    En attente d'enlèvement
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                    <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                    Aucun colis
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Centre : données --}}
                    <div class="flex-1 flex flex-col justify-center py-6">
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-black text-slate-900 tabular-nums">{{ $colisCount }}</span>
                            <span class="text-sm text-slate-500 font-medium uppercase tracking-wider">Colis prêts</span>
                        </div>
                        @if ($hasColis)
                            <ul class="mt-4 space-y-1">
                                @foreach ($transporteur->colis->take(3) as $colis)
                                    <li class="font-mono text-xs text-slate-400 truncate" title="{{ $colis->code_qr ?? $colis->id }}">
                                        {{ $colis->code_qr ?? Str::limit($colis->id, 12) }}
                                    </li>
                                @endforeach
                                @if ($colisCount > 3)
                                    <li class="font-mono text-xs text-slate-400 italic">
                                        +{{ $colisCount - 3 }} autre(s)
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>

                    {{-- Bas : action --}}
                    <div class="pt-4 border-t border-slate-100">
                        @if ($hasColis)
                            <form method="POST" action="{{ route('magasinier.expeditions.dispatch', $transporteur->id) }}" class="w-full">
                                @csrf
                                <button type="submit"
                                        class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-medium flex items-center justify-center gap-2 transition-all active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                                    <span>📦</span>
                                    <span>Valider le départ</span>
                                </button>
                            </form>
                        @else
                            <button type="button"
                                    disabled
                                    class="w-full py-3 bg-slate-100 text-slate-400 rounded-xl font-medium flex items-center justify-center gap-2 cursor-not-allowed opacity-60">
                                <span>📦</span>
                                <span>Valider le départ</span>
                            </button>
                        @endif
                    </div>
                </article>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-16 px-6 rounded-2xl bg-slate-50 border border-slate-200 border-dashed">
                    <span class="text-4xl mb-4">📦</span>
                    <p class="text-slate-600 font-medium">Aucun transporteur actif</p>
                    <p class="text-sm text-slate-500 mt-1">Les transporteurs sont configurés dans les paramètres système (Admin).</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
