<x-app-layout>
    <div class="space-y-8">
        <!-- Header de page -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">📊 Centre d'Analyse Logistique</h1>
                <p class="mt-1 text-gray-600">Rapports de performance et d'occupation en temps réel</p>
            </div>
            <button type="button"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-800 hover:bg-gray-700 text-white text-sm font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Exporter PDF
            </button>
        </div>

        <!-- Section 1 : KPIs de Performance -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Volume Mensuel</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $volumeMensuel }}</p>
                        <p class="mt-1 text-sm font-medium text-emerald-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            +12% vs mois dernier
                        </p>
                    </div>
                    <div class="p-3 rounded-xl bg-blue-50">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Délai moyen d'expédition</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $delaiMoyenExpedition }} <span class="text-lg font-normal text-gray-500">jours</span></p>
                    </div>
                    <div class="p-3 rounded-xl bg-amber-50">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Taux de ponctualité</p>
                        <p class="mt-2 text-3xl font-bold {{ $tauxLivraisonTemps >= 80 ? 'text-emerald-600' : ($tauxLivraisonTemps >= 50 ? 'text-amber-600' : 'text-rose-600') }}">
                            {{ $tauxLivraisonTemps }}%
                        </p>
                        <div class="mt-3 w-full bg-gray-200 rounded-full h-2.5">
                            <div class="h-2.5 rounded-full transition-all duration-500 {{ $tauxLivraisonTemps >= 80 ? 'bg-emerald-500' : ($tauxLivraisonTemps >= 50 ? 'bg-amber-500' : 'bg-rose-500') }}"
                                 style="width: {{ min($tauxLivraisonTemps, 100) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2 : Graphiques de Distribution -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Répartition par Statut -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Répartition par Statut</h3>
                <div class="space-y-4">
                    @php
                        $colors = [
                            'reçu' => 'bg-blue-500',
                            'en_stock' => 'bg-yellow-500',
                            'en_expédition' => 'bg-orange-500',
                            'livré' => 'bg-emerald-500',
                            'retour' => 'bg-purple-500',
                        ];
                    @endphp
                    @forelse($repartitionStatuts as $item)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700 capitalize">{{ $item->statut }}</span>
                                <span class="text-gray-500">{{ $item->total }} colis ({{ $item->pourcentage }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                                <div class="h-4 rounded-full transition-all duration-500 {{ $colors[$item->statut] ?? 'bg-gray-500' }}"
                                     style="width: {{ min($item->pourcentage, 100) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">Aucune donnée disponible</p>
                    @endforelse
                </div>
            </div>

            <!-- Top Transporteurs -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Top Transporteurs</h3>
                <div class="space-y-4">
                    @forelse($repartitionTransporteurs as $transporteur)
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg shrink-0">
                                {{ strtoupper(substr($transporteur->nom, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900">{{ $transporteur->nom }}</p>
                                <p class="text-sm text-gray-500">{{ $transporteur->colis_count }} colis pris en charge</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                    {{ $transporteur->colis_count }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">Aucun transporteur avec des colis</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Section 3 : Analyse de l'Entrepôt - Occupation par Zone -->
        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Analyse de l'Entrepôt — Occupation par Zone</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
                @forelse($occupationParZone as $zone)
                    @php
                        $zoneColor = $zone->taux >= 90 ? 'bg-red-500' : ($zone->taux >= 70 ? 'bg-amber-500' : 'bg-emerald-500');
                        $zoneBg = $zone->taux >= 90 ? 'bg-red-50 border-red-200' : ($zone->taux >= 70 ? 'bg-amber-50 border-amber-200' : 'bg-emerald-50 border-emerald-200');
                        $zoneText = $zone->taux >= 90 ? 'text-red-800' : ($zone->taux >= 70 ? 'text-amber-800' : 'text-emerald-800');
                        $zoneLabel = $zone->taux >= 90 ? 'Saturé' : ($zone->taux >= 70 ? 'Presque plein' : 'Disponible');
                    @endphp
                    <div class="p-4 rounded-xl border-2 {{ $zoneBg }} {{ $zoneText }} text-center">
                        <p class="font-bold text-lg">Zone {{ $zone->zone }}</p>
                        <p class="text-2xl font-extrabold mt-1">{{ $zone->taux }}%</p>
                        <p class="text-xs font-medium mt-1 opacity-90">{{ $zoneLabel }}</p>
                        <div class="mt-2 w-full bg-white/50 rounded-full h-2 overflow-hidden">
                            <div class="h-2 rounded-full {{ $zoneColor }} transition-all duration-500"
                                 style="width: {{ min($zone->taux, 100) }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-gray-500 text-center py-8">Aucune zone configurée</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
