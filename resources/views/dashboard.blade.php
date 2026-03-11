<x-app-layout>
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-green-800 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Section 1 : KPIs (4 cartes) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-sm border-l-4 border-l-blue-500 p-6">
                <p class="text-sm font-medium text-gray-500">En stock</p>
                <p class="mt-2 text-3xl font-bold text-blue-600">{{ $enStock }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border-l-4 border-l-orange-500 p-6">
                <p class="text-sm font-medium text-gray-500">En expédition</p>
                <p class="mt-2 text-3xl font-bold text-orange-600">{{ $enExpedition }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border-l-4 border-l-emerald-500 p-6">
                <p class="text-sm font-medium text-gray-500">Livrés (mois)</p>
                <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $livresMois }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border-l-4 border-l-rose-500 p-6">
                <p class="text-sm font-medium text-gray-500">Alertes</p>
                <p class="mt-2 text-3xl font-bold text-rose-600">{{ $alertes }}</p>
            </div>
        </div>

        <!-- Section 2 : Tableau Derniers colis reçus -->
        <div class="bg-white rounded-xl shadow-sm mt-6 overflow-hidden">
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

        <!-- Section 3 : Bandeau IA -->
        @if($colisFragilesEnRetard > 0)
            <div class="mt-6 bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-lg flex items-center gap-3">
                <span class="text-xl">✨</span>
                <p class="font-medium">
                    Assistant IA : {{ $colisFragilesEnRetard }} colis fragile(s) dépassent le délai — Action recommandée
                </p>
            </div>
        @else
            <div class="mt-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg flex items-center gap-3">
                <span class="text-xl">✨</span>
                <p class="font-medium">
                    Assistant IA : Aucun colis fragile en retard. Tous les envois sont dans les délais.
                </p>
            </div>
        @endif
    </div>
</x-app-layout>
