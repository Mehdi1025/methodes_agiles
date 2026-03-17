<x-app-simple-layout>
    <div class="px-6 py-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-6">Mes Colis du jour</h1>

        @if($colis->isEmpty())
            <div class="p-8 rounded-2xl bg-white border border-slate-200 text-center">
                <p class="text-xl text-slate-500">Aucun colis aujourd'hui</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($colis as $c)
                    <a href="{{ route('colis.show', $c) }}"
                       class="block p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md active:scale-[0.99] transition-all touch-manipulation">
                        <p class="text-xl font-mono font-bold text-slate-900">{{ $c->code_qr ?? $c->id }}</p>
                        <p class="text-lg text-slate-600 mt-1">{{ $c->client->nom ?? '—' }}</p>
                        @php
                            $badge = match($c->statut) {
                                'livré' => ['✅ LIVRÉ', 'text-emerald-600'],
                                'en_expédition' => ['🚚 EN EXPÉDITION', 'text-amber-600'],
                                'en_preparation' => ['📦 EN PRÉPARATION', 'text-amber-600'],
                                'en_stock' => ['📦 EN STOCK', 'text-slate-600'],
                                default => [strtoupper(str_replace('_', ' ', $c->statut)), 'text-slate-600'],
                            };
                        @endphp
                        <p class="text-lg font-semibold {{ $badge[1] }} mt-2">{{ $badge[0] }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-simple-layout>
