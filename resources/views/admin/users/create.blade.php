<x-app-layout>
    <div class="space-y-6 bg-zinc-50 min-h-full -m-6 p-6">
        <div class="mx-auto max-w-lg">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold tracking-tight text-slate-900">Ajouter un Employé</h2>
                <p class="mt-1 text-sm text-slate-500">Créer un nouveau compte utilisateur (magasinier ou administrateur)</p>

                <form method="POST" action="{{ route('admin.users.store') }}" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700">Nom</label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               class="mt-1 block w-full rounded-md border border-slate-200 px-3 py-2 text-slate-900 shadow-sm focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 @error('name') border-rose-500 @enderror" />
                        @error('name')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email') }}"
                               required
                               class="mt-1 block w-full rounded-md border border-slate-200 px-3 py-2 text-slate-900 shadow-sm focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 @error('email') border-rose-500 @enderror" />
                        @error('email')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700">Mot de passe</label>
                        <input type="password"
                               name="password"
                               id="password"
                               required
                               class="mt-1 block w-full rounded-md border border-slate-200 px-3 py-2 text-slate-900 shadow-sm focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 @error('password') border-rose-500 @enderror" />
                        @error('password')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirmer le mot de passe</label>
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               required
                               class="mt-1 block w-full rounded-md border border-slate-200 px-3 py-2 text-slate-900 shadow-sm focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900" />
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-slate-700">Rôle</label>
                        <select name="role"
                                id="role"
                                required
                                class="mt-1 block w-full rounded-md border border-slate-200 px-3 py-2 text-slate-900 shadow-sm focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 @error('role') border-rose-500 @enderror">
                            <option value="logistique" {{ old('role') === 'logistique' ? 'selected' : '' }}>Logistique (Magasinier)</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('admin.equipe.index') }}"
                           class="inline-flex h-10 items-center rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-900 transition-colors hover:bg-slate-50">
                            Annuler
                        </a>
                        <button type="submit"
                                class="inline-flex h-10 items-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-slate-800">
                            Créer le compte
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
