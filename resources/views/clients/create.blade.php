<x-app-layout>
    <x-slot name="header">Ajouter un client</x-slot>

    <div class="min-h-screen bg-slate-50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 py-8">
            <div class="mb-6">
                <a href="{{ route('clients.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Retour aux clients
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h1 class="text-xl font-bold text-slate-900">Nouveau client</h1>
                    <p class="text-sm text-slate-500 mt-0.5">Renseignez les informations du client</p>
                </div>

                <form action="{{ route('clients.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="nom" class="block text-sm font-medium text-slate-700 mb-2">Nom</label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                                   class="w-full rounded-xl border border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nom') border-red-300 @enderror">
                            @error('nom') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="prenom" class="block text-sm font-medium text-slate-700 mb-2">Prénom</label>
                            <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required
                                   class="w-full rounded-xl border border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('prenom') border-red-300 @enderror">
                            @error('prenom') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-300 @enderror">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="telephone" class="block text-sm font-medium text-slate-700 mb-2">Téléphone</label>
                        <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}" required
                               class="w-full rounded-xl border border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('telephone') border-red-300 @enderror">
                        @error('telephone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="adresse_livraison" class="block text-sm font-medium text-slate-700 mb-2">Adresse de livraison</label>
                        <textarea name="adresse_livraison" id="adresse_livraison" rows="3" required
                                  class="w-full rounded-xl border border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('adresse_livraison') border-red-300 @enderror">{{ old('adresse_livraison') }}</textarea>
                        @error('adresse_livraison') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-sm hover:shadow transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Créer le client
                        </button>
                        <a href="{{ route('clients.index') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition-all duration-200">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
