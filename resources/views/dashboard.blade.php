<x-app-layout>
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-green-800 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Ligne 1 : Actions Rapides (Quick Actions) --}}
        <div class="mb-10">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Tableau de bord logistique</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Bouton principal : Scanner un QR --}}
                <a href="{{ route('scanner.index') }}"
                   class="group relative flex items-center gap-4 p-6 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white shadow-md hover:-translate-y-1 hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative flex items-center justify-center w-14 h-14 rounded-xl bg-white/20 backdrop-blur-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <div class="relative">
                        <span class="block font-semibold text-lg">Scanner un QR</span>
                        <span class="block text-sm text-indigo-100 mt-0.5">Réception rapide</span>
                    </div>
                </a>
                {{-- Boutons secondaires --}}
                <a href="{{ route('colis.create') }}"
                   class="group flex items-center gap-4 p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:-translate-y-1 hover:shadow-lg hover:border-indigo-200/60 transition-all duration-300">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <div>
                        <span class="block font-semibold text-slate-800">Nouveau Colis</span>
                        <span class="block text-sm text-slate-500 mt-0.5">Créer un envoi</span>
                    </div>
                </a>
                <a href="{{ route('colis.index') }}"
                   class="group flex items-center gap-4 p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:-translate-y-1 hover:shadow-lg hover:border-slate-300 transition-all duration-300">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-slate-100 text-slate-600 group-hover:bg-slate-200/80 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <div>
                        <span class="block font-semibold text-slate-800">Rechercher</span>
                        <span class="block text-sm text-slate-500 mt-0.5">Explorer les colis</span>
                    </div>
                </a>
                <a href="{{ route('statistiques.index') }}"
                   class="group flex items-center gap-4 p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:-translate-y-1 hover:shadow-lg hover:border-slate-300 transition-all duration-300">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-slate-100 text-slate-600 group-hover:bg-slate-200/80 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <span class="block font-semibold text-slate-800">Historique</span>
                        <span class="block text-sm text-slate-500 mt-0.5">Statistiques & flux</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- Ligne 2 : Statistiques Avancées (KPI) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">En stock</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $enStock }}</p>
                        <div class="mt-3 inline-flex items-center gap-1.5 text-xs font-medium {{ ($tendanceEnStock ?? null) !== null ? ($tendanceEnStock >= 0 ? 'text-emerald-600' : 'text-rose-600') : 'text-slate-400' }}">
                            @if(($tendanceEnStock ?? null) !== null)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tendanceEnStock >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"/></svg>
                                <span>{{ $tendanceEnStock >= 0 ? '+' : '' }}{{ $tendanceEnStock }}% ce mois</span>
                            @else
                                <span>—</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-2.5 rounded-xl bg-blue-100">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">En expédition</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $enExpedition }}</p>
                        <div class="mt-3 inline-flex items-center gap-1.5 text-xs font-medium text-slate-400">
                            <span>—</span>
                        </div>
                    </div>
                    <div class="p-2.5 rounded-xl bg-amber-100">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Livrés (mois)</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $livresMois }}</p>
                        <div class="mt-3 inline-flex items-center gap-1.5 text-xs font-medium {{ ($tendanceLivres ?? null) !== null ? ($tendanceLivres >= 0 ? 'text-emerald-600' : 'text-rose-600') : 'text-slate-400' }}">
                            @if(($tendanceLivres ?? null) !== null && $livresMois > 0)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tendanceLivres >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"/></svg>
                                <span>{{ $tendanceLivres >= 0 ? '+' : '' }}{{ $tendanceLivres }}% vs mois préc.</span>
                            @else
                                <span>—</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-2.5 rounded-xl bg-emerald-100">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 hover:shadow-md transition-shadow duration-200 {{ $alertes > 0 ? 'ring-2 ring-rose-300/50' : '' }}">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Alertes</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $alertes }}</p>
                        <div class="mt-3 inline-flex items-center gap-1.5 text-xs font-medium {{ $alertes > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                            @if($alertes > 0)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <span>À traiter</span>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Aucune alerte</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-2.5 rounded-xl {{ $alertes > 0 ? 'bg-rose-100' : 'bg-slate-100' }}">
                        <svg class="w-6 h-6 {{ $alertes > 0 ? 'text-rose-600' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3 : Le Cœur (Grille asymétrique 2/3 - 1/3) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Colonne gauche : Tableau -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Derniers colis reçus</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID Colis</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Client</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($derniersColis as $colis)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">
                                        {{ Str::limit($colis->code_qr ?? $colis->id, 12) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $colis->client ? $colis->client->prenom . ' ' . $colis->client->nom : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgeClasses = match($colis->statut) {
                                                'livré' => 'bg-green-100 text-green-800',
                                                'en_stock' => 'bg-yellow-100 text-yellow-800',
                                                'en_expédition' => 'bg-orange-100 text-orange-800',
                                                'retour' => 'bg-purple-100 text-purple-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                        @endphp
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium {{ $badgeClasses }}">
                                            {{ $colis->statut }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $colis->date_reception?->format('d/m/Y') ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">Aucun colis enregistré.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Colonne droite : Capacité & Sécurité -->
            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Capacité & Sécurité</h3>

                <!-- Barre de progression Taux d'occupation -->
                <div class="mb-6">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="font-medium text-gray-600">Occupation entrepôt</span>
                        <span class="font-bold {{ $tauxOccupation >= 90 ? 'text-red-600' : ($tauxOccupation >= 70 ? 'text-orange-600' : 'text-emerald-600') }}">
                            {{ $tauxOccupation }}%
                        </span>
                    </div>
                    <div class="h-3 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500 {{ $tauxOccupation >= 90 ? 'bg-red-500' : ($tauxOccupation >= 70 ? 'bg-orange-500' : 'bg-emerald-500') }}"
                             style="width: {{ min($tauxOccupation, 100) }}%"></div>
                    </div>
                </div>

                <!-- Poids total -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">Poids total en rack</p>
                    <p class="text-xl font-bold text-gray-900 mt-1">{{ number_format($poidsTotal, 1, ',', ' ') }} kg</p>
                </div>

                <!-- Alerte colis fragiles -->
                @if($colisFragiles > 0)
                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-lg">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p class="text-sm font-medium text-amber-800">
                                Attention : {{ $colisFragiles }} colis fragile(s) en stock
                            </p>
                        </div>
                    </div>
                @else
                    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                        <p class="text-sm font-medium text-emerald-800">Aucun colis fragile en stock</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Section : Statistiques Avancées et Graphiques --}}
        <div class="space-y-6">
            <h3 class="text-lg font-semibold text-slate-800">Statistiques Avancées et Graphiques</h3>

            {{-- Ligne KPI Avancés --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Poids traité ce mois</p>
                            <p class="mt-1 text-2xl font-bold text-slate-900">{{ number_format($kpiAvances['poids_mois_kg'] ?? 0, 1, ',', ' ') }} <span class="text-base font-normal text-slate-500">kg</span></p>
                        </div>
                        <div class="p-2.5 rounded-xl bg-indigo-100">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                        </div>
                    </div>
                    <div class="mt-3 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        @php $poidsMois = $kpiAvances['poids_mois_kg'] ?? 0; $poidsProgress = $poidsTotal + $poidsMois > 0 ? min(100, round(($poidsMois / ($poidsTotal + $poidsMois)) * 100)) : 0; @endphp
                        <div class="h-full bg-indigo-500 rounded-full transition-all duration-700" style="width: {{ $poidsProgress }}%"></div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Taux d'expédition</p>
                            <p class="mt-1 text-2xl font-bold text-slate-900">{{ $kpiAvances['taux_expedition'] ?? 0 }}<span class="text-base font-normal text-slate-500">%</span></p>
                        </div>
                        <div class="p-2.5 rounded-xl bg-emerald-100">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        </div>
                    </div>
                    <div class="mt-3 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-700" style="width: {{ min($kpiAvances['taux_expedition'] ?? 0, 100) }}%"></div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Taux de retours</p>
                            <p class="mt-1 text-2xl font-bold text-slate-900">{{ $tauxRetours }}</p>
                        </div>
                        <div class="p-2.5 rounded-xl bg-purple-100">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Occupation</p>
                            <p class="mt-1 text-2xl font-bold text-slate-900">{{ $tauxOccupation }}<span class="text-base font-normal text-slate-500">%</span></p>
                        </div>
                        <div class="p-2.5 rounded-xl bg-amber-100">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                    </div>
                    <div class="mt-3 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-700 {{ $tauxOccupation >= 90 ? 'bg-rose-500' : ($tauxOccupation >= 70 ? 'bg-amber-500' : 'bg-emerald-500') }}" style="width: {{ min($tauxOccupation, 100) }}%"></div>
                    </div>
                </div>
            </div>

            {{-- Grille des Graphiques --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Graphique principal : Activité 7 derniers jours (2 colonnes) --}}
                <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h4 class="text-base font-semibold text-slate-800 mb-4">Activité des 7 derniers jours</h4>
                    @php $hasEvolutionData = collect($evolutionHebdo ?? [])->sum('total') > 0; @endphp
                    @if($hasEvolutionData)
                        <div id="chart-activite" class="min-h-[280px]"></div>
                    @else
                        <div class="min-h-[280px] flex flex-col items-center justify-center text-slate-400 py-12">
                            <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <p class="text-sm font-medium">Pas assez de données pour afficher le graphique</p>
                            <p class="text-xs mt-1">Les colis créés apparaîtront ici</p>
                        </div>
                    @endif
                </div>

                {{-- Graphique secondaire : Répartition des statuts (1 colonne) --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h4 class="text-base font-semibold text-slate-800 mb-4">Répartition des statuts</h4>
                    @php $hasStatutsData = !empty($statsStatuts) && array_sum($statsStatuts) > 0; @endphp
                    @if($hasStatutsData)
                        <div id="chart-statuts" class="min-h-[280px]"></div>
                    @else
                        <div class="min-h-[280px] flex flex-col items-center justify-center text-slate-400 py-12">
                            <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg>
                            <p class="text-sm font-medium">Pas assez de données pour afficher le graphique</p>
                            <p class="text-xs mt-1">Les statuts des colis apparaîtront ici</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.0/dist/apexcharts.min.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($hasEvolutionData ?? false)
            new ApexCharts(document.querySelector('#chart-activite'), {
                chart: { type: 'area', height: 280, fontFamily: 'inherit', toolbar: { show: false }, zoom: { enabled: false }, animations: { enabled: true, speed: 800 } },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0.1, stops: [0, 100] } },
                colors: ['#6366f1'],
                series: [{ name: 'Colis créés', data: @json(array_column($evolutionHebdo ?? [], 'total')) }],
                xaxis: { categories: @json(array_column($evolutionHebdo ?? [], 'label')), labels: { style: { colors: '#64748b', fontSize: '12px' } } },
                yaxis: { labels: { style: { colors: '#64748b' } }, min: 0, tickAmount: 4 },
                grid: { borderColor: '#f1f5f9', strokeDashArray: 4, xaxis: { lines: { show: false } } },
                tooltip: { theme: 'light', x: { show: true } }
            }).render();
            @endif

            @if($hasStatutsData ?? false)
            var statutsLabels = { 'reçu': 'Reçu', 'en_stock': 'En stock', 'en_expédition': 'En expédition', 'livré': 'Livré', 'retour': 'Retour' };
            var statutsColors = { 'reçu': '#3b82f6', 'en_stock': '#f59e0b', 'en_expédition': '#f97316', 'livré': '#10b981', 'retour': '#8b5cf6' };
            var statsData = @json($statsStatuts ?? []);
            new ApexCharts(document.querySelector('#chart-statuts'), {
                chart: { type: 'donut', height: 280, fontFamily: 'inherit', animations: { enabled: true, speed: 800 } },
                labels: Object.keys(statsData).map(function(k) { return statutsLabels[k] || k; }),
                series: Object.values(statsData),
                colors: Object.keys(statsData).map(function(k) { return statutsColors[k] || '#94a3b8'; }),
                legend: { position: 'bottom', fontSize: '13px', labels: { colors: '#64748b' } },
                plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', color: '#64748b' } } } } },
                tooltip: { theme: 'light', y: { formatter: function(v) { return v + ' colis'; } } }
            }).render();
            @endif
        });
        </script>

        <!-- Bandeau IA (Alertes) -->
        @if($colisFragilesEnRetard > 0)
            <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-lg flex items-center gap-3">
                <span class="text-xl">✨</span>
                <p class="font-medium">
                    Assistant IA : {{ $colisFragilesEnRetard }} colis fragile(s) dépassent le délai — Action recommandée
                </p>
            </div>
        @else
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg flex items-center gap-3">
                <span class="text-xl">✨</span>
                <p class="font-medium">
                    Assistant IA : Aucun colis fragile en retard. Tous les envois sont dans les délais.
                </p>
            </div>
        @endif
    </div>
</x-app-layout>
