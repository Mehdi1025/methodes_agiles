<x-app-layout>
    <div class="space-y-8">
        @if (session('success'))
            <div class="rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-green-800 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- En-tête -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Panneau d'Administration Central</h1>
            <p class="mt-1 text-gray-600">Supervision globale de la plateforme</p>
        </div>

        <!-- KPIs (4 cartes - thème corporate indigo/violet) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-md border-l-4 border-l-indigo-500 p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Utilisateurs actifs</p>
                        <p class="mt-2 text-3xl font-bold text-indigo-600">{{ $totalUtilisateurs }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-indigo-50">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border-l-4 border-l-violet-500 p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Clients enregistrés</p>
                        <p class="mt-2 text-3xl font-bold text-violet-600">{{ $totalClients }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-violet-50">
                        <svg class="w-8 h-8 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border-l-4 border-l-indigo-600 p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Volume Total Traité</p>
                        <p class="mt-2 text-3xl font-bold text-indigo-700">{{ $totalColisSysteme }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">colis</p>
                    </div>
                    <div class="p-3 rounded-lg bg-indigo-50">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border-l-4 border-l-emerald-500 p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Santé Système</p>
                        <span class="inline-flex items-center gap-1.5 mt-2 px-3 py-1.5 bg-emerald-100 text-emerald-800 rounded-lg text-sm font-semibold">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                            100% Opérationnel
                        </span>
                    </div>
                    <div class="p-3 rounded-lg bg-emerald-50">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Journal d'Audit Récent -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50/50 to-violet-50/50">
                <h3 class="text-lg font-semibold text-gray-800">Journal d'Audit Récent</h3>
                <p class="text-sm text-gray-500 mt-0.5">Dernières actions enregistrées sur la plateforme</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employé</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID Colis</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($derniersMouvements as $mouvement)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $mouvement->date_mouvement?->format('d/m/Y H:i') ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $mouvement->user?->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <span class="text-gray-500">{{ $mouvement->ancien_statut ?? '—' }}</span>
                                    <span class="mx-1 text-gray-400">→</span>
                                    <span class="font-medium text-indigo-600">{{ $mouvement->nouveau_statut }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">
                                    {{ $mouvement->colis ? Str::limit($mouvement->colis->code_qr ?? $mouvement->colis->id, 12) : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    Aucun mouvement enregistré.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
