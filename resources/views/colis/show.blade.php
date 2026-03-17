<x-app-layout>
    <div class="space-y-6">
        {{-- En-tête --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 print-hide">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Détail du Colis</h1>
                <p class="mt-1 text-sm text-gray-500 font-mono">{{ $colis->code_qr ?? $colis->id }}</p>
            </div>
            <a href="{{ route('colis.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 text-sm font-medium no-print">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour à la liste
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Contenu principal : Fiche produit --}}
            <div class="lg:col-span-2 space-y-6 print-hide">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6">
                        <div class="flex flex-wrap items-center gap-4 mb-6">
                            @php
                                $badgeClasses = match($colis->statut) {
                                    'livré' => 'bg-emerald-100 text-emerald-800',
                                    'en_stock' => 'bg-amber-100 text-amber-800',
                                    'en_expédition' => 'bg-orange-100 text-orange-800',
                                    'reçu' => 'bg-blue-100 text-blue-800',
                                    'retour' => 'bg-purple-100 text-purple-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="inline-flex px-4 py-2 rounded-full text-sm font-medium {{ $badgeClasses }}">
                                {{ str_replace('_', ' ', ucfirst($colis->statut)) }}
                            </span>
                            @if($colis->fragile)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-800 rounded-lg text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    Fragile
                                </span>
                            @endif
                        </div>

                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Client
                                </dt>
                                <dd class="mt-1">
                                    @if($colis->client)
                                        <a href="{{ route('clients.show', $colis->client->id) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 hover:underline">{{ $colis->client->prenom }} {{ $colis->client->nom }}</a>
                                    @else
                                        <span class="text-sm font-semibold text-gray-900">-</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Date de réception
                                </dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $colis->date_reception?->format('d/m/Y') ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                                    Poids
                                </dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $colis->poids_kg ?? '-' }} kg</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4a2 2 0 00-2 2v4m0-4v12m0-4h4m0 4v4m0 0h4m-4 0v-12m0 4h4m0-4V4"/></svg>
                                    Dimensions
                                </dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $colis->dimensions ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Date d'expédition
                                </dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $colis->date_expedition?->format('d/m/Y') ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                    Transporteur
                                </dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $colis->transporteur->nom ?? '-' }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    Emplacement
                                </dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">
                                    {{ $colis->emplacement ? $colis->emplacement->zone . ' — Allée ' . $colis->emplacement->allee : '-' }}
                                </dd>
                            </div>
                            @if($colis->description)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                                    Description
                                </dt>
                                <dd class="mt-1 text-sm text-gray-700">{{ $colis->description }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Sidebar : QR Code + Actions rapides --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- QR Code en grand (visible à l'écran et à l'impression) --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 flex flex-col items-center">
                        <div class="w-48 h-48 p-4 bg-white rounded-lg border border-gray-100 shadow-sm [&>svg]:w-full [&>svg]:h-full">
                            {!! $colis->qr_code_svg !!}
                        </div>
                        <p class="mt-3 font-mono text-sm text-gray-600">{{ $colis->code_qr ?? $colis->id }}</p>
                    </div>
                </div>

                {{-- Actions rapides --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden no-print">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-800">Actions rapides</h3>
                    </div>
                    <div class="p-4 space-y-2">
                        <button type="button" onclick="window.print()" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2h-2m-4-1h.01"/>
                            </svg>
                            Imprimer l'étiquette
                        </button>
                        <a href="{{ route('colis.edit', $colis->id) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-amber-50 hover:bg-amber-100 text-amber-700 text-sm font-medium rounded-lg border border-amber-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Modifier
                        </a>
                        <form action="{{ route('colis.destroy', $colis->id) }}" method="POST" onsubmit="return confirm('Supprimer ce colis ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-rose-50 hover:bg-rose-100 text-rose-700 text-sm font-medium rounded-lg border border-rose-200 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    @media print {
        .no-print, .print-hide { display: none !important; }
        aside, nav, header, [role="navigation"], .flex.h-screen > aside { display: none !important; }
        .grid > *:first-child { display: none !important; }
        body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
    }
    </style>
</x-app-layout>
