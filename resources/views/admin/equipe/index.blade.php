<x-app-layout>
    <div class="space-y-6 bg-zinc-50 min-h-full -m-6 p-6">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">
                {{ session('error') }}
            </div>
        @endif

        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Gestion de l'Équipe</h1>
                <p class="mt-1 text-sm text-slate-500">Créer, modifier et gérer les comptes employés</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
               class="inline-flex h-10 items-center gap-2 rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-slate-800">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un Employé
            </a>
        </div>

        <!-- Tableau des utilisateurs -->
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h3 class="font-semibold tracking-tight text-slate-900">Liste des Employés</h3>
                <p class="mt-0.5 text-sm text-slate-500">{{ $utilisateurs->total() }} utilisateur(s) enregistré(s)</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Rôle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Créé le</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($utilisateurs as $u)
                            <tr class="transition-colors hover:bg-slate-50/50">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">{{ $u->name }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $u->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-medium {{ $u->role === 'admin' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700' }}">
                                        {{ $u->role === 'admin' ? 'Admin' : 'Logistique' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">{{ $u->created_at?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-6 py-4 text-right">
                                    @if($u->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline" onsubmit="return confirm('Supprimer cet employé ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center rounded-md border border-rose-200 bg-white px-2.5 py-1.5 text-xs font-medium text-rose-700 transition-colors hover:bg-rose-50">
                                                Supprimer
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">Aucun utilisateur.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($utilisateurs->hasPages())
                <div class="border-t border-slate-200 px-6 py-3">
                    {{ $utilisateurs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
