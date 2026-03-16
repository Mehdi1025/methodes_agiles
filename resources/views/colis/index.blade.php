<!-- d:\projet_methode_agile2\resources\views\colis\index.blade.php -->

<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Colis</h1>
            <a href="{{ route('colis.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">Ajouter un colis</a>
        </div>

        <!-- Indicateurs -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white shadow rounded p-4 flex items-center">
                <div class="bg-blue-100 p-2 rounded-full mr-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7"/><path d="M3 7l9-4 9 4"/></svg>
                </div>
                <div>
                    <div class="text-lg font-bold">{{ $totalColis ?? '...' }}</div>
                    <div class="text-gray-500 text-sm">Colis total</div>
                </div>
            </div>
            <div class="bg-white shadow rounded p-4 flex items-center">
                <div class="bg-green-100 p-2 rounded-full mr-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3"/></svg>
                </div>
                <div>
                    <div class="text-lg font-bold">{{ $colisLivres ?? '...' }}</div>
                    <div class="text-gray-500 text-sm">Colis livrés</div>
                </div>
            </div>
            <div class="bg-white shadow rounded p-4 flex items-center">
                <div class="bg-yellow-100 p-2 rounded-full mr-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3"/></svg>
                </div>
                <div>
                    <div class="text-lg font-bold">{{ $colisEnCours ?? '...' }}</div>
                    <div class="text-gray-500 text-sm">Colis en cours</div>
                </div>
            </div>
        </div>

        <!-- Tableau des colis -->
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($colis as $colisItem)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $colisItem['id'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $colisItem->client->nom ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $colisItem['statut'] == 'livré' ? 'bg-green-100 text-green-700' : ($colisItem['statut'] == 'en cours' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                                    {{ ucfirst($colisItem['statut']) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $colisItem['date_reception'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('colis.show', $colisItem['id']) }}" class="text-blue-600 hover:underline mr-2">Voir</a>
                                <a href="{{ route('colis.edit', $colisItem['id']) }}" class="text-yellow-600 hover:underline mr-2">Modifier</a>
                                <form action="{{ route('colis.destroy', $colisItem['id']) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Supprimer ce colis ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun colis trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Bloc Top clients -->
        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">Top Clients</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($topClients ?? [] as $client)
                    <div class="bg-white shadow rounded p-4">
                        <div class="text-lg font-bold">{{ $client->nom }}</div>
                        <div class="text-gray-500 text-sm">Colis envoyés : {{ $client->colis_count ?? 0 }}</div>
                    </div>
                @endforeach
                @if(empty($topClients))
                    <div class="text-gray-500">Aucun client à afficher.</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
