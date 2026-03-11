<x-app-layout>
    <div class="space-y-6 bg-zinc-50 min-h-full -m-6 p-6">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <!-- 1. En-tête -->
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Paramètres du Système</h1>
            <p class="mt-1 text-sm text-slate-500">Gestion des référentiels et de la configuration de l'entrepôt</p>
        </div>

        <!-- 2. Grille Principale -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Colonne Gauche (1/3) - Ajouter un Transporteur -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="font-semibold tracking-tight text-slate-900">Ajouter un Transporteur</h3>
                <p class="mt-1 text-sm text-slate-500">Nouveau transporteur dans le référentiel</p>

                <form method="POST" action="{{ route('admin.transporteurs.store') }}" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label for="nom" class="block text-sm font-medium text-slate-700">Nom du transporteur</label>
                        <input type="text"
                               name="nom"
                               id="nom"
                               value="{{ old('nom') }}"
                               required
                               class="mt-1 block w-full rounded-md border border-slate-200 px-3 py-2 text-slate-900 shadow-sm focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 @error('nom') border-rose-500 @enderror" />
                        @error('nom')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="telephone" class="block text-sm font-medium text-slate-700">Téléphone</label>
                        <input type="text"
                               name="telephone"
                               id="telephone"
                               value="{{ old('telephone') }}"
                               class="mt-1 block w-full rounded-md border border-slate-200 px-3 py-2 text-slate-900 shadow-sm focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 @error('telephone') border-rose-500 @enderror" />
                        @error('telephone')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                            class="w-full rounded-md bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-slate-800">
                        Ajouter
                    </button>
                </form>
            </div>

            <!-- Colonne Droite (2/3) - Référentiel des Transporteurs -->
            <div class="lg:col-span-2 rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h3 class="font-semibold tracking-tight text-slate-900">Référentiel des Transporteurs</h3>
                    <p class="mt-0.5 text-sm text-slate-500">{{ $transporteurs->count() }} transporteur(s)</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Statut</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($transporteurs as $t)
                                <tr class="transition-colors hover:bg-slate-50/50">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">{{ $t->nom }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $t->telephone ?? $t->contact ?? '—' }}</td>
                                    <td class="px-6 py-4">
                                        @if($t->is_active ?? true)
                                            <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Actif</span>
                                        @else
                                            <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600">Inactif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form method="POST" action="{{ route('admin.transporteurs.destroy', $t->id) }}" class="inline" onsubmit="return confirm('Supprimer ce transporteur ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center rounded-md border border-rose-200 px-2.5 py-1.5 text-xs font-medium text-rose-600 transition-colors hover:bg-rose-50">
                                                Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500">Aucun transporteur. Ajoutez-en un ci-contre.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
