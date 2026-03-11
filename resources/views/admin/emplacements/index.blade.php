<x-app-layout>
    <div class="space-y-6 bg-zinc-50 min-h-full -m-6 p-6">
        <!-- 1. En-tête & Légende -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Cartographie de l'Entrepôt</h1>
                <p class="mt-1 text-sm text-slate-500">
                    <span class="font-medium text-slate-900">{{ $libres }}</span> libres / <span class="font-medium text-slate-900">{{ $occupes }}</span> occupés
                    <span class="text-slate-400">—</span> {{ $total }} emplacements total
                </p>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="h-4 w-4 rounded bg-emerald-500 shadow-sm"></span>
                    <span class="text-sm text-slate-600">Emplacement Libre</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-4 w-4 rounded bg-rose-500 shadow-sm"></span>
                    <span class="text-sm text-slate-600">Emplacement Occupé</span>
                </div>
            </div>
        </div>

        <!-- 2. La Carte Interactive -->
        @foreach($emplacements as $zone => $lieux)
            <div class="mb-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm last:mb-0">
                <h2 class="mb-4 text-lg font-semibold tracking-tight text-slate-900">Zone {{ $zone }}</h2>
                <div class="grid grid-cols-5 sm:grid-cols-8 md:grid-cols-10 gap-3">
                    @foreach($lieux as $lieu)
                        @php
                            $occupe = $lieu->occupe || $lieu->colis->isNotEmpty();
                            $colis = $lieu->colis->first();
                        @endphp
                        <div class="group relative aspect-square cursor-pointer">
                            <div class="flex h-full w-full items-center justify-center rounded-md text-xs font-bold text-white shadow-sm transition-all hover:scale-105 {{ $occupe ? 'bg-rose-500' : 'bg-emerald-500' }}">
                                {{ $lieu->zone }}{{ $lieu->allee }}
                            </div>
                            <div class="pointer-events-none absolute bottom-full left-1/2 z-10 mb-2 w-48 -translate-x-1/2 rounded bg-slate-900 p-2 text-xs text-white shadow-lg opacity-0 transition-opacity group-hover:opacity-100">
                                <p class="font-medium">Emplacement : {{ $lieu->zone }}-{{ $lieu->allee }}</p>
                                @if($occupe && $colis)
                                    <p class="mt-1 text-slate-300">📦 Colis : {{ $colis->code_qr ?? Str::limit($colis->id, 8) }}</p>
                                    <p class="text-slate-300">Poids : {{ number_format($colis->poids_kg ?? 0, 1, ',', ' ') }} kg</p>
                                @else
                                    <p class="mt-1 text-emerald-400">✨ Prêt à stocker</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        @if($emplacements->isEmpty())
            <div class="rounded-xl border border-slate-200 bg-white p-12 text-center shadow-sm">
                <p class="text-slate-500">Aucun emplacement configuré.</p>
            </div>
        @endif
    </div>
</x-app-layout>
