<x-app-layout>
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-green-800 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Section 1 : En-tête & Actions Rapides -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-bold text-gray-900">Vue d'ensemble</h1>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('colis.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouveau Colis
                </a>
                <a href="{{ route('scanner.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    Scanner QR
                </a>
                <a href="{{ route('assistant-ia.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-violet-50 text-violet-700 text-sm font-medium rounded-lg border-2 border-violet-300 shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    Optimisation IA
                </a>
            </div>
        </div>

        <!-- Section 2 : KPIs Principaux -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-sm border-l-4 border-l-blue-500 p-6 hover:shadow-md transition-shadow duration-200">
                <p class="text-sm font-medium text-gray-500">En stock</p>
                <p class="mt-2 text-3xl font-bold text-blue-600">{{ $enStock }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border-l-4 border-l-orange-500 p-6 hover:shadow-md transition-shadow duration-200">
                <p class="text-sm font-medium text-gray-500">En expédition</p>
                <p class="mt-2 text-3xl font-bold text-orange-600">{{ $enExpedition }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border-l-4 border-l-emerald-500 p-6 hover:shadow-md transition-shadow duration-200">
                <p class="text-sm font-medium text-gray-500">Livrés (mois)</p>
                <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $livresMois }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border-l-4 border-l-rose-500 p-6 hover:shadow-md transition-shadow duration-200 {{ $alertes > 0 ? 'ring-2 ring-rose-400 ring-opacity-50 animate-pulse' : '' }}">
                <p class="text-sm font-medium text-gray-500">Alertes</p>
                <p class="mt-2 text-3xl font-bold text-rose-600">{{ $alertes }}</p>
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

        <!-- Section 4 : Statistiques Avancées -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">📊 Statistiques Avancées</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Carte 1 : Taux de Retours -->
                <div class="bg-gray-100/50 rounded-xl p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white rounded-lg shadow-sm">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Taux de Retours</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $tauxRetours }}</p>
                        </div>
                    </div>
                </div>

                <!-- Carte 2 : Activité du jour -->
                <div class="bg-gray-100/50 rounded-xl p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="p-2 bg-white rounded-lg shadow-sm">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Activité du jour</p>
                    </div>
                    <div class="flex items-end gap-1 h-12">
                        <div class="flex-1 bg-blue-400 rounded-t" style="height: 40%"></div>
                        <div class="flex-1 bg-blue-500 rounded-t" style="height: 70%"></div>
                        <div class="flex-1 bg-blue-400 rounded-t" style="height: 55%"></div>
                        <div class="flex-1 bg-blue-500 rounded-t" style="height: 85%"></div>
                        <div class="flex-1 bg-blue-400 rounded-t" style="height: 60%"></div>
                        <div class="flex-1 bg-blue-500 rounded-t" style="height: 75%"></div>
                        <div class="flex-1 bg-blue-600 rounded-t" style="height: 90%"></div>
                    </div>
                    <p class="mt-2 text-sm font-medium text-emerald-600">Flux stable</p>
                </div>

                <!-- Carte 3 : Disponibilité IA -->
                <div class="bg-gray-100/50 rounded-xl p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white rounded-lg shadow-sm">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Disponibilité IA</p>
                            <span class="inline-flex items-center gap-1.5 mt-1 px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-sm font-medium">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                Mistral-7B Connecté
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
