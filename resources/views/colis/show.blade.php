<x-app-layout>
<div class="max-w-2xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Détail du Colis</h2>
    <div class="bg-white shadow rounded p-6">
        <div class="mb-4">
            <span class="font-semibold text-gray-700">ID :</span> {{ $colis['id'] }}
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700">Client :</span> {{ $colis->client->nom ?? '-' }}
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700">Statut :</span> {{ ucfirst($colis['statut']) }}
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700">Description :</span> {{ $colis->description ?? '-' }}
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700">Poids (kg) :</span> {{ $colis->poids_kg ?? '-' }}
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700">Dimensions :</span> {{ $colis->dimensions ?? '-' }}
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700">Fragile :</span> {{ $colis->fragile ? 'Oui' : 'Non' }}
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700">Date de réception :</span> {{ $colis->date_reception ?? '-' }}
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700">Date d'expédition :</span> {{ $colis->date_expedition ?? '-' }}
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700">Transporteur :</span> {{ $colis->transporteur->nom ?? '-' }}
        </div>
        <div class="mb-4">
            <span class="font-semibold text-gray-700">Emplacement :</span> 
            {{ $colis->emplacement->zone ?? '-' }} - Allée {{ $colis->emplacement->allee ?? '-' }}
        </div>
        <a href="{{ route('colis.edit', $colis['id']) }}" class="bg-yellow-600 text-white font-semibold px-4 py-2 rounded shadow">Modifier</a>
        <form action="{{ route('colis.destroy', $colis['id']) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white font-semibold px-4 py-2 rounded shadow ml-4" onclick="return confirm('Supprimer ce colis ?')">Supprimer</button>
        </form>
        <a href="{{ route('colis.index') }}" class="ml-4 text-gray-600">Retour</a>
    </div>
</div>
</x-app-layout>
