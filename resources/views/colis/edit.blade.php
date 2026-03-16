<x-app-layout>
<div class="max-w-2xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Modifier le Colis</h2>
    @if ($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('colis.update', $colis['id']) }}" method="POST" class="bg-white shadow rounded p-6">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="client_id" class="block text-gray-700 font-semibold mb-2">Client</label>
            <select name="client_id" id="client_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">Sélectionner un client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" @if($colis->client_id == $client->id) selected @endif>
                        {{ $client->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="statut" class="block text-gray-700 font-semibold mb-2">Statut</label>
            <select name="statut" id="statut" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="reçu" @if($colis->statut == 'reçu') selected @endif>Reçu</option>
                <option value="en_stock" @if($colis->statut == 'en_stock') selected @endif>En stock</option>
                <option value="en_expédition" @if($colis->statut == 'en_expédition') selected @endif>En expédition</option>
                <option value="livré" @if($colis->statut == 'livré') selected @endif>Livré</option>
                <option value="retour" @if($colis->statut == 'retour') selected @endif>Retour</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" id="description" class="w-full border border-gray-300 rounded px-3 py-2">{{ $colis->description }}</textarea>
        </div>
        <div class="mb-4">
            <label for="poids_kg" class="block text-gray-700 font-semibold mb-2">Poids (kg)</label>
            <input type="number" step="0.01" name="poids_kg" id="poids_kg" value="{{ $colis->poids_kg }}" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label for="dimensions" class="block text-gray-700 font-semibold mb-2">Dimensions</label>
            <input type="text" name="dimensions" id="dimensions" value="{{ $colis->dimensions }}" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label for="fragile" class="block text-gray-700 font-semibold mb-2">Fragile</label>
            <input type="checkbox" name="fragile" id="fragile" value="1" @if($colis->fragile) checked @endif>
        </div>
        <div class="mb-4">
            <label for="date_expedition" class="block text-gray-700 font-semibold mb-2">Date d'expédition</label>
            <input type="date" name="date_expedition" id="date_expedition" value="{{ $colis->date_expedition }}" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label for="date_reception" class="block text-gray-700 font-semibold mb-2">Date de réception</label>
            <input type="date" name="date_reception" id="date_reception" value="{{ $colis->date_reception }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label for="transporteur_id" class="block text-gray-700 font-semibold mb-2">Transporteur</label>
            <select name="transporteur_id" id="transporteur_id" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">Sélectionner un transporteur</option>
                @foreach($transporteurs as $transporteur)
                    <option value="{{ $transporteur->id }}" @if($colis->transporteur_id == $transporteur->id) selected @endif>
                        {{ $transporteur->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="emplacement_id" class="block text-gray-700 font-semibold mb-2">Emplacement</label>
            <select name="emplacement_id" id="emplacement_id" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">Sélectionner un emplacement</option>
                @foreach($emplacements as $emplacement)
                    <option value="{{ $emplacement->id }}" @if($colis->emplacement_id == $emplacement->id) selected @endif>
                        {{ $emplacement->zone }} - Allée {{ $emplacement->allee }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-yellow-600 text-white font-semibold px-4 py-2 rounded shadow">Modifier</button>
        <a href="{{ route('colis.index') }}" class="ml-4 text-gray-600">Annuler</a>
    </form>
</div>
</x-app-layout>
