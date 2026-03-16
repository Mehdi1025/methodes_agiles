
<x-app-layout>
<div class="max-w-2xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Ajouter un Colis</h2>
    <form action="{{ route('colis.store') }}" method="POST" class="bg-white shadow rounded p-6">
        @csrf
        <div class="mb-4">
            <label for="client_id" class="block text-gray-700 font-semibold mb-2">Client</label>
            <select name="client_id" id="client_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">Sélectionner un client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="statut" class="block text-gray-700 font-semibold mb-2">Statut</label>
            <select name="statut" id="statut" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="reçu">Reçu</option>
                <option value="en_stock">En stock</option>
                <option value="en_expédition">En expédition</option>
                <option value="livré">Livré</option>
                <option value="retour">Retour</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="date_reception" class="block text-gray-700 font-semibold mb-2">Date de réception</label>
            <input type="date" name="date_reception" id="date_reception" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white font-semibold px-4 py-2 rounded shadow">Ajouter</button>
        <a href="{{ route('colis.index') }}" class="ml-4 text-gray-600">Annuler</a>
    </form>
</div>
</x-app-layout>
