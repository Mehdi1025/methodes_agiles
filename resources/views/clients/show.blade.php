<x-app-layout>
    <x-slot name="header">Profil Client 360°</x-slot>

    <div class="min-h-screen bg-slate-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
            @if(session('success'))
                <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200/80 px-4 py-3 text-emerald-800 text-sm font-medium shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Fil d'Ariane --}}
            <div class="mb-6">
                <a href="{{ route('clients.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Clients
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                {{-- Colonne gauche : Profil & Stats --}}
                <div class="lg:col-span-4 space-y-6">
                    {{-- Carte Profil --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="p-8 text-center">
                            @php
                                $initials = strtoupper(substr($client->prenom ?? '', 0, 1) . substr($client->nom ?? '', 0, 1));
                                $colors = ['bg-indigo-100 text-indigo-700', 'bg-emerald-100 text-emerald-700', 'bg-amber-100 text-amber-700', 'bg-rose-100 text-rose-700', 'bg-teal-100 text-teal-700'];
                                $colorClass = $colors[abs(crc32($client->id)) % count($colors)];
                            @endphp
                            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full {{ $colorClass }} text-2xl font-bold mb-4">
                                {{ $initials ?: '?' }}
                            </div>
                            <h1 class="text-xl font-bold text-slate-900 mb-1">{{ $client->prenom }} {{ $client->nom }}</h1>
                            <div class="space-y-2 mt-4 text-sm text-slate-600">
                                @if($client->telephone)
                                    <p class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        {{ $client->telephone }}
                                    </p>
                                @endif
                                @if($client->email)
                                    <p class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        <a href="mailto:{{ $client->email }}" class="hover:text-indigo-600 transition-colors">{{ $client->email }}</a>
                                    </p>
                                @endif
                            </div>
                            <a href="{{ route('colis.create', ['client_id' => $client->id]) }}"
                               class="mt-6 inline-flex items-center justify-center gap-2 w-full py-4 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 active:scale-[0.98]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Nouveau colis pour ce client
                            </a>
                        </div>
                    </div>

                    {{-- Mini-Statistiques --}}
                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 text-center">
                            <div class="inline-flex p-2.5 rounded-xl bg-slate-100 mb-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <p class="text-2xl font-bold text-slate-900">{{ $totalColis }}</p>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">Total colis</p>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 text-center">
                            <div class="inline-flex p-2.5 rounded-xl bg-amber-100 mb-2">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            </div>
                            <p class="text-2xl font-bold text-slate-900">{{ $colisEnCours }}</p>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">En transit</p>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 text-center">
                            <div class="inline-flex p-2.5 rounded-xl bg-emerald-100 mb-2">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <p class="text-2xl font-bold text-slate-900">{{ $colisLivres }}</p>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">Livrés</p>
                        </div>
                    </div>
                </div>

                {{-- Colonne droite : Timeline Historique --}}
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100">
                            <h2 class="text-lg font-semibold text-slate-800">Historique des colis</h2>
                            <p class="text-sm text-slate-500 mt-0.5">Frise chronologique de l'activité logistique</p>
                        </div>
                        <div class="p-6">
                            @if($client->colis->isNotEmpty())
                                <div class="relative border-l-2 border-slate-100 pl-6 space-y-0">
                                    @foreach($client->colis as $coli)
                                        @php
                                            $dotColor = match($coli->statut) {
                                                'livré' => 'bg-emerald-500',
                                                'en_expédition', 'en_preparation' => 'bg-amber-500',
                                                default => 'bg-slate-400',
                                            };
                                            $badgeClasses = match($coli->statut) {
                                                'livré' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                                'en_stock' => 'bg-amber-50 text-amber-700 border-amber-100',
                                                'en_expédition' => 'bg-orange-50 text-orange-700 border-orange-100',
                                                'en_preparation' => 'bg-amber-50 text-amber-700 border-amber-100',
                                                'reçu' => 'bg-blue-50 text-blue-700 border-blue-100',
                                                'retour' => 'bg-purple-50 text-purple-700 border-purple-100',
                                                'anomalie' => 'bg-rose-50 text-rose-700 border-rose-100',
                                                default => 'bg-slate-50 text-slate-700 border-slate-100',
                                            };
                                            $dateDisplay = $coli->created_at->diffInDays(now()) <= 7
                                                ? $coli->created_at->diffForHumans()
                                                : $coli->created_at->translatedFormat('d F Y');
                                        @endphp
                                        <div class="relative flex gap-4 pb-8 last:pb-0">
                                            <div class="absolute -left-[29px] top-1.5 w-4 h-4 rounded-full {{ $dotColor }} border-2 border-white shadow-sm"></div>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-bold text-slate-900 font-mono">{{ $coli->code_qr ?? $coli->id }}</p>
                                                <p class="text-sm text-slate-500 mt-0.5">{{ $dateDisplay }}</p>
                                                <div class="flex flex-wrap items-center gap-2 mt-2">
                                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-medium border {{ $badgeClasses }}">
                                                        {{ str_replace('_', ' ', ucfirst($coli->statut)) }}
                                                    </span>
                                                    <a href="{{ route('colis.show', $coli->id) }}"
                                                       class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">
                                                        Voir détails
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="py-16 text-center">
                                    <div class="inline-flex p-4 rounded-2xl bg-slate-100 mb-4">
                                        <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <p class="text-slate-600 font-medium">Aucun colis pour ce client</p>
                                    <p class="text-slate-400 text-sm mt-1">Créez votre premier colis pour commencer l'historique</p>
                                    <a href="{{ route('colis.create', ['client_id' => $client->id]) }}"
                                       class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow-sm transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Nouveau colis
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
