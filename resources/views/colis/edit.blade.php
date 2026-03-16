
<x-app-layout>
<div class="max-w-2xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Modifier le Colis</h2>
    <form action="{{ route('colis.update', $colis['id']) }}" method="POST" class="bg-white shadow rounded p-6">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="client_id" class="block text-gray-700 font-semibold mb-2">Client</label>
            <select name="client_id" id="client_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="">Sélectionner un client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" @if($colis->client_id == $client->id) selected @endif>{{ $client->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="statut" class="block text-gray-700 font-semibold mb-2">Statut</label>
            <select name="statut" id="statut" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="reçu" @if($colis['statut']=='reçu') selected @endif>Reçu</option>
                <option value="en_stock" @if($colis['statut']=='en_stock') selected @endif>En stock</option>
                <option value="en_expédition" @if($colis['statut']=='en_expédition') selected @endif>En expédition</option>
                <option value="livré" @if($colis['statut']=='livré') selected @endif>Livré</option>
                <option value="retour" @if($colis['statut']=='retour') selected @endif>Retour</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="date_reception" class="block text-gray-700 font-semibold mb-2">Date de réception</label>
            <input type="date" name="date_reception" id="date_reception" value="{{ $colis->date_reception }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>
        <button type="submit" class="bg-yellow-600 text-white font-semibold px-4 py-2 rounded shadow">Modifier</button>
        <a href="{{ route('colis.index') }}" class="ml-4 text-gray-600">Annuler</a>
    </form>
</div>
</x-app-layout>
