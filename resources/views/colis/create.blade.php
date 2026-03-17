<x-app-layout>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-bold text-gray-900">Nouveau Colis</h1>
            <a href="{{ route('colis.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour à la liste
            </a>
        </div>

        <form action="{{ route('colis.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Section Scan --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-transparent">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Scan & Identifiant</h2>
                            <p class="text-sm text-gray-500">Scannez le QR Code ou saisissez l'identifiant manuellement</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label for="code_qr" class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            Code QR / Identifiant
                        </label>
                        <div class="flex gap-3">
                            <input type="text" name="code_qr" id="code_qr" value="{{ old('code_qr') }}"
                                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Scannez ou saisissez le code" maxlength="50">
                            <div class="flex gap-2">
                                <button type="button" id="btn-open-camera"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-indigo-500/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13v7a2 2 0 01-2 2H7a2 2 0 01-2-2v-7"/>
                                    </svg>
                                    Scanner un QR Code
                                </button>
                                <button type="button" id="btn-open-import"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-xl shadow-sm border border-slate-200 hover:border-slate-300 transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Importer une image
                                </button>
                            </div>
                        </div>
                        @error('code_qr') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Section Informations Générales --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-800">Informations Générales</h2>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="client_id" class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Client
                        </label>
                        <select name="client_id" id="client_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Sélectionner un client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id', request('client_id')) == $client->id ? 'selected' : '' }}>{{ $client->nom }}{{ $client->prenom ? ' (' . $client->prenom . ')' : '' }}</option>
                            @endforeach
                        </select>
                        @error('client_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="statut" class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Statut
                        </label>
                        <select name="statut" id="statut" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="reçu" {{ old('statut', 'reçu') == 'reçu' ? 'selected' : '' }}>Reçu</option>
                            <option value="en_stock" {{ old('statut') == 'en_stock' ? 'selected' : '' }}>En stock</option>
                            <option value="en_expédition" {{ old('statut') == 'en_expédition' ? 'selected' : '' }}>En expédition</option>
                            <option value="livré" {{ old('statut') == 'livré' ? 'selected' : '' }}>Livré</option>
                            <option value="retour" {{ old('statut') == 'retour' ? 'selected' : '' }}>Retour</option>
                        </select>
                        @error('statut') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="date_reception" class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Date de réception
                        </label>
                        <input type="date" name="date_reception" id="date_reception" value="{{ old('date_reception') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('date_reception') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                            Description
                        </label>
                        <textarea name="description" id="description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Description du colis">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Section Logistique --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-amber-100 rounded-lg">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-800">Logistique</h2>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="poids_kg" class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                            Poids (kg)
                        </label>
                        <input type="number" step="0.01" name="poids_kg" id="poids_kg" value="{{ old('poids_kg') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="0.00">
                        @error('poids_kg') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="dimensions" class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4a2 2 0 00-2 2v4m0-4v12m0-4h4m0 4v4m0 0h4m-4 0v-12m0 4h4m0-4V4"/></svg>
                            Dimensions
                        </label>
                        <input type="text" name="dimensions" id="dimensions" value="{{ old('dimensions') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="L x l x H">
                        @error('dimensions') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            Fragile
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="fragile" id="fragile" value="1" {{ old('fragile') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm text-gray-600">Ce colis est fragile</span>
                        </label>
                        @error('fragile') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="date_expedition" class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Date d'expédition
                        </label>
                        <input type="date" name="date_expedition" id="date_expedition" value="{{ old('date_expedition') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('date_expedition') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="transporteur_id" class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            Transporteur
                        </label>
                        <select name="transporteur_id" id="transporteur_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Sélectionner un transporteur</option>
                            @foreach($transporteurs as $transporteur)
                                <option value="{{ $transporteur->id }}" {{ old('transporteur_id') == $transporteur->id ? 'selected' : '' }}>{{ $transporteur->nom }}</option>
                            @endforeach
                        </select>
                        @error('transporteur_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="emplacement_id" class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Emplacement
                        </label>
                        <select name="emplacement_id" id="emplacement_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Sélectionner un emplacement</option>
                            @foreach($emplacements as $emplacement)
                                <option value="{{ $emplacement->id }}" {{ old('emplacement_id') == $emplacement->id ? 'selected' : '' }}>
                                    {{ $emplacement->zone }} — Allée {{ $emplacement->allee }}
                                </option>
                            @endforeach
                        </select>
                        @error('emplacement_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Enregistrer le colis
                </button>
                <a href="{{ route('colis.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                    Annuler
                </a>
            </div>
        </form>

        {{-- Modale Scanner QR — Design Grand Prix --}}
        <div id="scanner-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/70 backdrop-blur-sm p-4" aria-hidden="true">
            <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full overflow-hidden border border-slate-200/80" id="scanner-modal-content">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-lg font-semibold text-slate-800 tracking-tight">Scanner un QR Code</h3>
                    <button type="button" id="btn-close-camera" class="p-2.5 rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-all duration-200" aria-label="Fermer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="p-6">
                    <input type="file" id="scan-file-input" accept="image/*" class="hidden">
                    <div class="relative rounded-2xl overflow-hidden shadow-xl bg-slate-900 min-h-[280px]" id="reader-wrapper">
                        <div id="reader" class="rounded-2xl [&>div]:rounded-2xl [&>video]:rounded-2xl min-h-[280px]"></div>
                        <div id="reader-import-placeholder" class="absolute inset-0 hidden flex-col items-center justify-center text-slate-400 text-sm">
                            <svg class="w-12 h-12 mb-2 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/></svg>
                            <p>Glissez-déposez une image ou cliquez sur Importer</p>
                        </div>
                        {{-- Overlay cadre de visée --}}
                        <div id="viewfinder-overlay" class="absolute inset-0 pointer-events-none flex flex-col items-center justify-center">
                            <div id="viewfinder-frame" class="relative w-56 h-56 flex items-center justify-center overflow-hidden">
                                <div class="absolute inset-0 border-2 border-indigo-400/80 rounded-xl viewfinder-pulse"></div>
                                <div id="laser-line" class="absolute left-0 right-0 h-0.5 bg-red-500/90 rounded-full laser-sweep shadow-[0_0_8px_2px_rgba(239,68,68,0.6)]"></div>
                                <div class="absolute -top-1 -left-1 w-8 h-8 border-l-4 border-t-4 border-indigo-500 rounded-tl-lg"></div>
                                <div class="absolute -top-1 -right-1 w-8 h-8 border-r-4 border-t-4 border-indigo-500 rounded-tr-lg"></div>
                                <div class="absolute -bottom-1 -left-1 w-8 h-8 border-l-4 border-b-4 border-indigo-500 rounded-bl-lg"></div>
                                <div class="absolute -bottom-1 -right-1 w-8 h-8 border-r-4 border-b-4 border-indigo-500 rounded-br-lg"></div>
                            </div>
                            <p id="viewfinder-hint" class="mt-4 text-sm font-medium text-white/90 drop-shadow-lg animate-fade-pulse">Centrez le QR Code ici</p>
                        </div>
                        {{-- Overlay assombri (opacité 0.7) --}}
                        <div id="viewfinder-mask" class="absolute inset-0 pointer-events-none rounded-2xl" style="background: radial-gradient(ellipse 140px 140px at 50% 42%, transparent 0%, rgba(0,0,0,0.7) 100%);"></div>
                        {{-- Carte flottante Anti-Spam (Valider / Scanner à nouveau) --}}
                        <div id="scan-confirm-card" class="absolute inset-x-4 bottom-4 z-30 hidden flex-col p-4 rounded-2xl bg-white/95 backdrop-blur-md shadow-2xl border border-slate-200/80">
                            <p class="text-xs font-medium text-slate-500 mb-1">Code détecté</p>
                            <p id="scan-confirm-code" class="font-mono font-bold text-slate-900 text-lg mb-4 truncate"></p>
                            <div class="flex gap-3">
                                <button type="button" id="btn-scan-validate" class="flex-1 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
                                    Valider
                                </button>
                                <button type="button" id="btn-scan-retry" class="flex-1 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition-colors">
                                    Scanner à nouveau
                                </button>
                            </div>
                        </div>
                        {{-- Succès : flash vert + check --}}
                        <div id="scan-success-overlay" class="absolute inset-0 hidden items-center justify-center bg-emerald-500/20 rounded-2xl">
                            <div id="scan-success-check" class="w-20 h-20 rounded-full bg-emerald-500 flex items-center justify-center shadow-2xl scale-0">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>
                        {{-- Indicateur drag & drop --}}
                        <div id="reader-drag-hint" class="absolute inset-0 hidden items-center justify-center bg-slate-900/90 rounded-2xl border-2 border-dashed border-indigo-400/50 z-20 pointer-events-none">
                            <p class="text-white/90 text-sm font-medium">Déposez ici une image</p>
                        </div>
                    </div>
                    {{-- Barre de contrôle matériel (Torche, Caméra, Son) --}}
                    <div id="scanner-controls" class="mt-3 hidden flex justify-center gap-2">
                        <button type="button" id="btn-torch" class="hidden p-3 rounded-xl bg-slate-100/80 hover:bg-slate-200/80 backdrop-blur-sm text-slate-600 transition-all" aria-label="Torche" title="Torche">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        </button>
                        <button type="button" id="btn-switch-camera" class="p-3 rounded-xl bg-slate-100/80 hover:bg-slate-200/80 backdrop-blur-sm text-slate-600 transition-all" aria-label="Changer de caméra" title="Changer de caméra">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </button>
                        <button type="button" id="btn-sound-toggle" class="p-3 rounded-xl bg-slate-100/80 hover:bg-slate-200/80 backdrop-blur-sm text-slate-600 transition-all" aria-label="Son" title="Activer/Désactiver le bip">
                            <svg id="icon-sound-on" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/></svg>
                            <svg id="icon-sound-off" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/></svg>
                        </button>
                        <button type="button" id="btn-import-image" class="p-3 rounded-xl bg-slate-100/80 hover:bg-slate-200/80 backdrop-blur-sm text-slate-600 transition-all" aria-label="Importer image" title="Importer une image">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </button>
                    </div>
                    <div class="mt-2 flex justify-center">
                        <button type="button" id="btn-import-image-text" class="inline-flex items-center gap-2 px-4 py-2 text-slate-500 hover:text-indigo-600 text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/></svg>
                            Importer une image
                        </button>
                    </div>
                    <div id="scanner-error" class="mt-4 hidden p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm flex flex-col gap-3">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 shrink-0 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <div>
                                <p class="font-semibold" id="scanner-error-title">Accès à la caméra impossible</p>
                                <p class="mt-1 text-amber-700/90" id="scanner-error-text"></p>
                                <p class="mt-2 text-xs text-amber-600/80">Vérifiez les paramètres de votre navigateur, autorisez l'accès à la caméra pour ce site, ou réessayez après avoir rafraîchi la page.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Toast de succès --}}
        <div id="scan-toast" class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[60] flex items-center gap-2 hidden px-6 py-4 rounded-xl bg-slate-800 text-white text-sm font-medium shadow-2xl border border-slate-700/50 transition-all duration-300 translate-y-4 opacity-0">
            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-emerald-500 text-white text-xs font-bold">✓</span>
            <span id="scan-toast-message"></span>
        </div>
        {{-- Toast d'erreur --}}
        <div id="scan-toast-error" class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[60] flex items-center gap-2 hidden px-6 py-4 rounded-xl bg-red-600 text-white text-sm font-medium shadow-2xl border border-red-500/50 transition-all duration-300 translate-y-4 opacity-0">
            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white text-xs font-bold">!</span>
            <span id="scan-toast-error-message"></span>
        </div>

        <style>
        @keyframes viewfinder-pulse { 0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4); } 50% { opacity: 0.8; box-shadow: 0 0 20px 2px rgba(99, 102, 241, 0.3); } }
        .viewfinder-pulse { animation: viewfinder-pulse 2s ease-in-out infinite; }
        @keyframes fade-pulse { 0%, 100% { opacity: 0.9; } 50% { opacity: 0.6; } }
        .animate-fade-pulse { animation: fade-pulse 2s ease-in-out infinite; }
        @keyframes laser-sweep { 0%, 100% { top: 5%; } 50% { top: 95%; } }
        .laser-sweep { animation: laser-sweep 2s ease-in-out infinite; }
        #viewfinder-frame.viewfinder-flash-success [class*="border-indigo"] { border-color: rgb(52 211 153) !important; }
        #viewfinder-frame.viewfinder-flash-success .viewfinder-pulse { border-color: rgb(52 211 153) !important; box-shadow: 0 0 24px 4px rgba(52, 211, 153, 0.5) !important; }
        #viewfinder-frame.viewfinder-flash-success .laser-sweep { animation: none; opacity: 0; }
        </style>
    </div>

<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('scanner-modal');
    const modalContent = document.getElementById('scanner-modal-content');
    const btnOpen = document.getElementById('btn-open-camera');
    const btnOpenImport = document.getElementById('btn-open-import');
    const btnImportImage = document.getElementById('btn-import-image');
    const btnClose = document.getElementById('btn-close-camera');
    const fileInput = document.getElementById('scan-file-input');
    const codeQrInput = document.getElementById('code_qr');
    const readerDiv = document.getElementById('reader');
    const readerWrapper = document.getElementById('reader-wrapper');
    const readerDragHint = document.getElementById('reader-drag-hint');
    const readerPlaceholder = document.getElementById('reader-import-placeholder');
    const viewfinderOverlay = document.getElementById('viewfinder-overlay');
    const errorEl = document.getElementById('scanner-error');
    const errorText = document.getElementById('scanner-error-text');
    const errorTitle = document.getElementById('scanner-error-title');
    const toast = document.getElementById('scan-toast');
    const toastMessage = document.getElementById('scan-toast-message');
    const toastError = document.getElementById('scan-toast-error');
    const toastErrorMessage = document.getElementById('scan-toast-error-message');
    const viewfinderFrame = document.getElementById('viewfinder-frame');
    const viewfinderHint = document.getElementById('viewfinder-hint');
    const successOverlay = document.getElementById('scan-success-overlay');
    const successCheck = document.getElementById('scan-success-check');
    const scanConfirmCard = document.getElementById('scan-confirm-card');
    const scanConfirmCode = document.getElementById('scan-confirm-code');
    const btnScanValidate = document.getElementById('btn-scan-validate');
    const btnScanRetry = document.getElementById('btn-scan-retry');
    const scannerControls = document.getElementById('scanner-controls');
    const btnTorch = document.getElementById('btn-torch');
    const btnSwitchCamera = document.getElementById('btn-switch-camera');
    const btnSoundToggle = document.getElementById('btn-sound-toggle');
    const iconSoundOn = document.getElementById('icon-sound-on');
    const iconSoundOff = document.getElementById('icon-sound-off');
    const btnImportImageText = document.getElementById('btn-import-image-text');

    let html5QrCode = null;
    let isScanning = false;
    let isProcessingFile = false;
    let soundEnabled = true;
    let currentFacingMode = 'environment';
    let pendingScannedCode = null;

    function playSuccessBeep() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const playTone = (freq, start, duration, vol) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.frequency.value = freq;
                osc.type = 'sine';
                gain.gain.setValueAtTime(vol, ctx.currentTime + start);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + start + duration);
                osc.start(ctx.currentTime + start);
                osc.stop(ctx.currentTime + start + duration);
            };
            playTone(523.25, 0, 0.08, 0.15);
            playTone(659.25, 0.1, 0.12, 0.12);
        } catch (e) { /* fallback */ }
    }

    function showError(title, msg) {
        errorTitle.textContent = title || 'Accès à la caméra impossible';
        errorText.textContent = msg || 'Vérifiez les paramètres de votre navigateur.';
        errorEl.classList.remove('hidden');
    }

    function hideError() {
        errorEl.classList.add('hidden');
    }

    function showToast(message) {
        toastErrorMessage.textContent = '';
        toastError.classList.add('hidden');
        toastMessage.textContent = message;
        toast.classList.remove('hidden', 'translate-y-4', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        setTimeout(() => {
            toast.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => toast.classList.add('hidden'), 300);
        }, 3200);
    }

    function showErrorToast(message) {
        toast.classList.add('hidden');
        toastErrorMessage.textContent = message;
        toastError.classList.remove('hidden', 'translate-y-4', 'opacity-0');
        toastError.classList.add('translate-y-0', 'opacity-100');
        setTimeout(() => {
            toastError.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => toastError.classList.add('hidden'), 300);
        }, 3200);
    }

    function closeModal() {
        modalContent.style.transition = 'transform 0.25s ease, opacity 0.25s ease';
        modalContent.style.transform = 'scale(0.96)';
        modalContent.style.opacity = '0';
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 250);
    }

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modalContent.style.transition = 'transform 0.3s ease, opacity 0.3s ease';
        modalContent.style.transform = 'scale(0.96)';
        modalContent.style.opacity = '0';
        requestAnimationFrame(() => {
            modalContent.style.transform = 'scale(1)';
            modalContent.style.opacity = '1';
        });
    }

    function openModalForImport() {
        hideError();
        readerDiv.innerHTML = '';
        readerDiv.classList.remove('hidden');
        readerPlaceholder.classList.remove('hidden');
        readerPlaceholder.classList.add('flex');
        if (viewfinderOverlay) viewfinderOverlay.classList.add('hidden');
        readerDragHint.classList.add('hidden');
        readerDragHint.classList.remove('flex');
        successOverlay.classList.add('hidden');
        successOverlay.classList.remove('flex');
        hideScanConfirmCard();
        scannerControls.classList.add('hidden');
        if (viewfinderFrame) viewfinderFrame.classList.remove('viewfinder-flash-success');
        if (viewfinderHint) viewfinderHint.classList.add('hidden');
        openModal();
    }

    function triggerHaptic() {
        if (navigator.vibrate) navigator.vibrate([200, 100, 200]);
    }

    function applyScanSuccess(decodedText) {
        stopScanner();
        if (soundEnabled) playSuccessBeep();
        triggerHaptic();
        codeQrInput.value = decodedText;
        codeQrInput.focus();

        if (viewfinderHint) viewfinderHint.classList.add('hidden');
        if (viewfinderFrame) viewfinderFrame.classList.add('viewfinder-flash-success');

        successOverlay.classList.remove('hidden');
        successOverlay.classList.add('flex');
        successCheck.style.animation = 'none';
        successCheck.offsetHeight;
        successCheck.style.animation = 'scan-check-pop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards';

        setTimeout(() => {
            closeModal();
            showToast('Code ' + decodedText + ' scanné et prêt !');
        }, 450);
    }

    function validateScannedCode() {
        if (pendingScannedCode) {
            applyScanSuccess(pendingScannedCode);
            pendingScannedCode = null;
            scanConfirmCard.classList.add('hidden');
        }
    }

    function resumeScanning() {
        pendingScannedCode = null;
        hideScanConfirmCard();
        if (viewfinderHint) viewfinderHint.classList.remove('hidden');
        if (html5QrCode && html5QrCode.getState() === 2) {
            html5QrCode.resume();
        }
    }

    async function onScanSuccess(decodedText) {
        if (!isScanning || pendingScannedCode) return;
        pendingScannedCode = decodedText;
        html5QrCode.pause();
        if (soundEnabled) playSuccessBeep();
        triggerHaptic();
        successOverlay.classList.remove('hidden');
        successOverlay.classList.add('flex');
        successOverlay.classList.add('bg-emerald-500/30');
        successCheck.style.animation = 'none';
        successCheck.offsetHeight;
        successCheck.style.animation = 'scan-check-pop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards';
        setTimeout(() => {
            successOverlay.classList.remove('bg-emerald-500/30');
            successOverlay.classList.add('hidden');
            successOverlay.classList.remove('flex');
        }, 300);
        scanConfirmCode.textContent = decodedText;
        scanConfirmCard.classList.remove('hidden');
        scanConfirmCard.classList.add('flex');
        if (viewfinderHint) viewfinderHint.classList.add('hidden');
    }

    function hideScanConfirmCard() {
        scanConfirmCard.classList.add('hidden');
        scanConfirmCard.classList.remove('flex');
    }

    async function processFile(file) {
        if (!file || !file.type.startsWith('image/')) return;
        if (isProcessingFile) return;
        isProcessingFile = true;
        hideError();
        readerDragHint.classList.add('hidden');
        readerDragHint.classList.remove('flex');

        const scanWithFile = async () => {
            try {
                const scanner = new Html5Qrcode('reader');
                const decodedText = await scanner.scanFile(file, false);
                applyScanSuccess(decodedText);
            } catch (err) {
                showErrorToast('Aucun QR Code détecté dans cette image');
            } finally {
                isProcessingFile = false;
                fileInput.value = '';
            }
        };

        readerPlaceholder.classList.add('hidden');
        if (isScanning) {
            await stopScanner();
            readerDiv.innerHTML = '';
            readerDiv.classList.remove('hidden');
        } else {
            readerDiv.innerHTML = '';
            readerDiv.classList.remove('hidden');
        }
        await scanWithFile();
    }

    async function startScanner() {
        if (isScanning) return;
        hideError();
        pendingScannedCode = null;
        hideScanConfirmCard();
        readerDiv.innerHTML = '';
        readerPlaceholder.classList.add('hidden');
        readerPlaceholder.classList.remove('flex');
        if (viewfinderOverlay) viewfinderOverlay.classList.remove('hidden');
        successOverlay.classList.add('hidden');
        successOverlay.classList.remove('flex');
        successCheck.style.animation = 'none';
        if (viewfinderHint) viewfinderHint.classList.remove('hidden');
        if (viewfinderFrame) viewfinderFrame.classList.remove('viewfinder-flash-success');

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            openModal();
            showError('Caméra non supportée', 'Votre navigateur ou appareil ne permet pas l\'accès à la caméra. Utilisez Chrome, Firefox ou Safari sur un appareil compatible.');
            return;
        }

        openModal();

        try {
            html5QrCode = new Html5Qrcode('reader');
            await html5QrCode.start(
                { facingMode: currentFacingMode },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                onScanSuccess,
                () => {}
            );
            isScanning = true;
            scannerControls.classList.remove('hidden');
            btnTorch.classList.add('hidden');
            try {
                const caps = html5QrCode.getRunningTrackCameraCapabilities();
                const torch = caps && typeof caps.torchFeature === 'function' ? caps.torchFeature() : null;
                if (torch && typeof torch.apply === 'function') btnTorch.classList.remove('hidden');
            } catch (e) { /* torch non supporté */ }
        } catch (err) {
            scannerControls.classList.add('hidden');
            const msg = err.message || '';
            const isPermission = /permission|denied|refused/i.test(msg);
            showError(
                isPermission ? 'Permission refusée' : 'Accès impossible',
                isPermission ? 'L\'accès à la caméra a été refusé. Cliquez sur l\'icône cadenas dans la barre d\'adresse, autorisez la caméra, puis réessayez.' : (msg || 'Vérifiez les paramètres de votre navigateur.')
            );
        }
    }

    function toggleTorch() {
        if (!html5QrCode || !isScanning) return;
        try {
            const caps = html5QrCode.getRunningTrackCameraCapabilities();
            const torch = caps && typeof caps.torchFeature === 'function' ? caps.torchFeature() : null;
            if (torch && typeof torch.apply === 'function') torch.apply(!torch.value());
        } catch (e) { /* ignore */ }
    }

    async function switchCamera() {
        if (!html5QrCode || !isScanning) return;
        currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
        await stopScanner();
        readerDiv.innerHTML = '';
        readerDiv.classList.remove('hidden');
        try {
            html5QrCode = new Html5Qrcode('reader');
            await html5QrCode.start(
                { facingMode: currentFacingMode },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                onScanSuccess,
                () => {}
            );
            isScanning = true;
            btnTorch.classList.add('hidden');
            try {
                const caps = html5QrCode.getRunningTrackCameraCapabilities();
                const torch = caps && typeof caps.torchFeature === 'function' ? caps.torchFeature() : null;
                if (torch && typeof torch.apply === 'function') btnTorch.classList.remove('hidden');
            } catch (e) { /* torch non supporté */ }
        } catch (e) { currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment'; }
    }

    function stopScanner() {
        if (html5QrCode && isScanning) {
            return html5QrCode.stop().then(() => {
                isScanning = false;
                html5QrCode = null;
            }).catch(() => { isScanning = false; });
        }
        return Promise.resolve();
    }

    const urlParams = new URLSearchParams(window.location.search);
    const codeFromUrl = urlParams.get('code_qr');
    if (codeFromUrl) {
        codeQrInput.value = codeFromUrl;
    }

    btnOpen.addEventListener('click', startScanner);
    btnOpenImport.addEventListener('click', openModalForImport);
    btnImportImage.addEventListener('click', () => fileInput.click());
    if (btnImportImageText) btnImportImageText.addEventListener('click', () => fileInput.click());
    btnScanValidate.addEventListener('click', validateScannedCode);
    btnScanRetry.addEventListener('click', resumeScanning);
    btnTorch.addEventListener('click', toggleTorch);
    btnSwitchCamera.addEventListener('click', switchCamera);
    btnSoundToggle.addEventListener('click', function() {
        soundEnabled = !soundEnabled;
        iconSoundOn.classList.toggle('hidden', !soundEnabled);
        iconSoundOff.classList.toggle('hidden', soundEnabled);
    });
    fileInput.addEventListener('change', function() {
        const file = this.files?.[0];
        if (file) processFile(file);
    });

    readerWrapper.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        readerDragHint.classList.remove('hidden');
        readerDragHint.classList.add('flex');
    });
    readerWrapper.addEventListener('dragleave', function(e) {
        e.preventDefault();
        if (!readerWrapper.contains(e.relatedTarget)) {
            readerDragHint.classList.add('hidden');
            readerDragHint.classList.remove('flex');
        }
    });
    readerWrapper.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        readerDragHint.classList.add('hidden');
        readerDragHint.classList.remove('flex');
        const file = e.dataTransfer?.files?.[0];
        if (file && file.type.startsWith('image/')) processFile(file);
    });

    btnClose.addEventListener('click', function() {
        stopScanner();
        hideError();
        pendingScannedCode = null;
        hideScanConfirmCard();
        scannerControls.classList.add('hidden');
        closeModal();
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            stopScanner();
            hideError();
            pendingScannedCode = null;
            hideScanConfirmCard();
            scannerControls.classList.add('hidden');
            closeModal();
        }
    });
});
</script>
<style>
@keyframes scan-check-pop { 0% { transform: scale(0); opacity: 0; } 70% { transform: scale(1.1); } 100% { transform: scale(1); opacity: 1; } }
</style>
</x-app-layout>
