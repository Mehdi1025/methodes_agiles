<x-app-layout>
    <div class="space-y-6 bg-zinc-50/50 min-h-full -m-6 p-6">
        <!-- 1. En-tête -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Rapports & Analyses Logistiques</h1>
            <a href="{{ route('statistiques.export-csv') }}"
               class="inline-flex h-10 items-center gap-2 rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-900 transition-colors hover:bg-slate-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Télécharger le rapport (CSV)
            </a>
        </div>

        <!-- 2. Aperçu Global (4 cartes) -->
        <div>
            <p class="mb-3 text-sm font-medium text-slate-500">Aperçu Global</p>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Total Colis Traités</p>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-2xl font-semibold tracking-tight text-slate-900">{{ number_format($totalColis, 0, ',', ' ') }}</span>
                        @if($tendanceMois != 0)
                            <span class="rounded-md border border-slate-200 bg-slate-50 px-1.5 py-0.5 text-xs font-medium {{ $tendanceMois >= 0 ? 'text-emerald-600' : 'text-rose-500' }}">
                                {{ $tendanceMois >= 0 ? '+' : '' }}{{ $tendanceMois }}% vs mois dernier
                            </span>
                        @endif
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Délai Moyen Expédition</p>
                    <p class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">{{ $delaiMoyenExpedition }}</p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Taux de Livraison à l'Heure</p>
                    <p class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">{{ $tauxLivraisonHeure }}%</p>
                    <div class="mt-2 h-1 w-full overflow-hidden rounded-full bg-slate-100">
                        <div class="h-1 rounded-full bg-emerald-500 transition-all" style="width: {{ min($tauxLivraisonHeure, 100) }}%"></div>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Taux de Retour</p>
                    <p class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">{{ $tauxRetour }}%</p>
                    <div class="mt-2 h-1 w-full overflow-hidden rounded-full bg-slate-100">
                        <div class="h-1 rounded-full bg-rose-500 transition-all" style="width: {{ min($tauxRetour, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Analyse de l'Entrepôt (2 colonnes) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Carte Gauche : Occupation par Zone -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="font-semibold tracking-tight text-slate-900">Occupation par Zone</h3>
                <p class="mt-0.5 text-sm text-slate-500">Répartition et remplissage des zones A, B, C</p>

                <div class="mt-6 space-y-4">
                    @foreach($occupationParZone as $item)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-slate-500">Zone {{ $item->zone }}</span>
                                <span class="font-medium text-slate-900">{{ $item->pourcentage }}%</span>
                            </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-slate-100">
                                <div class="h-2 rounded-full bg-slate-900 transition-all" style="width: {{ min($item->pourcentage, 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 grid grid-cols-3 gap-4">
                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4">
                        <p class="text-sm text-slate-500">Poids Total en Stock</p>
                        <p class="mt-1 font-semibold tracking-tight text-slate-900">{{ number_format($poidsTotalStock, 1, ',', ' ') }} kg</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4">
                        <p class="text-sm text-slate-500">Valeur Estimée</p>
                        <p class="mt-1 font-semibold tracking-tight text-slate-900">{{ number_format($valeurEstimeeStock, 0, ',', ' ') }} €</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4">
                        <p class="text-sm text-slate-500">Colis Fragiles</p>
                        <p class="mt-1 font-semibold tracking-tight text-slate-900">{{ $pourcentageFragile }}%</p>
                    </div>
                </div>
            </div>

            <!-- Carte Droite : Répartition par Statuts -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="font-semibold tracking-tight text-slate-900">Répartition par Statuts</h3>
                <p class="mt-0.5 text-sm text-slate-500">Distribution des colis selon leur état</p>

                <div class="mt-6 space-y-4">
                    @php $maxStatut = $repartitionStatuts->max('total') ?: 1; @endphp
                    @forelse($repartitionStatuts as $statut)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-slate-900">{{ $statut->label }}</span>
                                <span class="text-slate-500">{{ $statut->total }} ({{ $statut->pourcentage }}%)</span>
                            </div>
                            <div class="h-1.5 w-full overflow-hidden rounded-full bg-slate-100">
                                <div class="h-1.5 rounded-full bg-slate-300 transition-all" style="width: {{ $maxStatut > 0 ? min(100, ($statut->total / $maxStatut) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Aucun colis enregistré.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- 4. Performance Partenaires -->
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h3 class="font-semibold tracking-tight text-slate-900">Performance Partenaires</h3>
                <p class="mt-0.5 text-sm text-slate-500">Top transporteurs par volume et taux de succès</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Transporteur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Volume Géré</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Taux de Succès</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($topTransporteurs as $t)
                            <tr class="transition-colors hover:bg-slate-50/50">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">{{ $t->nom }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $t->volume }} colis</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $t->taux_succes }}%</td>
                                <td class="px-6 py-4">
                                    @php
                                        $badgeClass = match($t->statut) {
                                            'excellent' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                            'bon' => 'border-slate-200 bg-slate-50 text-slate-700',
                                            default => 'border-rose-200 bg-rose-50 text-rose-700',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-md border px-2 py-0.5 text-xs font-medium {{ $badgeClass }}">
                                        {{ $t->statut === 'excellent' ? 'Excellent' : ($t->statut === 'bon' ? 'Bon' : 'Attention') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500">Aucun transporteur avec des colis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
