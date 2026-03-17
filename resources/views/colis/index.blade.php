<x-app-layout>
    <div class="space-y-8">
        @if(session('success'))
            <div class="rounded-xl bg-emerald-50 border border-emerald-200/80 px-4 py-3 text-emerald-800 text-sm font-medium shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- En-tête & Actions --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Gestion des Colis</h1>
                <p class="mt-1 text-sm text-slate-500">Suivez et gérez l'ensemble de vos colis</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('colis.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow-sm hover:shadow transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nouveau Colis
                </a>
                <a href="{{ route('scanner.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-xl border border-slate-200 shadow-sm hover:shadow transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    Scanner QR
                </a>
            </div>
        </div>

        {{-- Section Statistiques (4 cartes) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md p-6 transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Colis</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $totalColis }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-blue-50 group-hover:bg-blue-100 transition-colors">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md p-6 transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Colis Fragiles</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $colisFragiles }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-amber-50 group-hover:bg-amber-100 transition-colors">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md p-6 transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Expédiés aujourd'hui</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $expediesAujourdhui }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-emerald-50 group-hover:bg-emerald-100 transition-colors">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md p-6 transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">En attente</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $enAttente }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-100 group-hover:bg-slate-200 transition-colors">
                        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau + Recherche --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-lg font-semibold text-slate-800">Liste des colis</h3>
                <form method="GET" action="{{ route('colis.index') }}" id="search-form" class="flex-1 sm:max-w-xs">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="search" name="search" id="search-input" value="{{ request('search') }}" placeholder="Rechercher (code, client, description)..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" autocomplete="off">
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">QR</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($colis as $colisItem)
                            <tr class="hover:bg-slate-50/80 transition-colors duration-200 group">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="text-sm font-mono text-slate-600">{{ Str::limit($colisItem->code_qr ?? $colisItem->id, 14) }}</span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <button type="button" class="qr-thumb inline-flex items-center justify-center w-14 h-14 p-2 rounded-xl border border-slate-100 bg-white hover:scale-110 hover:border-indigo-200 hover:shadow-md transition-all duration-200" data-colis-id="{{ $colisItem->id }}" data-code="{{ $colisItem->code_qr ?? $colisItem->id }}" title="Cliquer pour imprimer">
                                        <div class="w-10 h-10 [&>svg]:w-full [&>svg]:h-full">{!! $colisItem->qr_code_svg_small !!}</div>
                                    </button>
                                    <template id="qr-template-{{ $colisItem->id }}">{!! $colisItem->qr_code_svg !!}</template>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="text-sm font-medium text-slate-900">{{ $colisItem->client->nom ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @php
                                        $badgeClasses = match($colisItem->statut) {
                                            'livré' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                            'en_stock' => 'bg-amber-50 text-amber-700 border-amber-100',
                                            'en_expédition' => 'bg-orange-50 text-orange-700 border-orange-100',
                                            'reçu' => 'bg-blue-50 text-blue-700 border-blue-100',
                                            'retour' => 'bg-purple-50 text-purple-700 border-purple-100',
                                            default => 'bg-slate-50 text-slate-700 border-slate-100',
                                        };
                                    @endphp
                                    <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-medium border {{ $badgeClasses }}">
                                        {{ str_replace('_', ' ', ucfirst($colisItem->statut)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm text-slate-600">
                                    {{ $colisItem->date_reception?->format('d/m/Y') ?? '-' }}
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-1 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('colis.show', $colisItem->id) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 text-sm font-medium transition-all duration-200" title="Voir">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Voir
                                        </a>
                                        <a href="{{ route('colis.edit', $colisItem->id) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-slate-600 hover:bg-amber-50 hover:text-amber-700 text-sm font-medium transition-all duration-200" title="Modifier">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Modifier
                                        </a>
                                        <form action="{{ route('colis.destroy', $colisItem->id) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce colis ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-slate-600 hover:bg-rose-50 hover:text-rose-600 text-sm font-medium transition-all duration-200" title="Supprimer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20">
                                    <div class="flex flex-col items-center justify-center text-center">
                                        <div class="w-20 h-20 mb-5 rounded-2xl bg-slate-100 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                        <p class="text-slate-600 font-semibold">Aucun colis trouvé</p>
                                        <p class="text-slate-400 text-sm mt-1 max-w-sm">Commencez par ajouter votre premier colis ou modifiez votre recherche</p>
                                        <a href="{{ route('colis.create') }}" class="mt-5 inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow-sm transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Ajouter un colis
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($colis->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-center">
                <nav class="flex items-center gap-1" aria-label="Pagination">
                    @if ($colis->onFirstPage())
                        <span class="inline-flex items-center px-3 py-2 rounded-lg text-slate-400 cursor-not-allowed text-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </span>
                    @else
                        <a href="{{ $colis->previousPageUrl() }}" class="inline-flex items-center px-3 py-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 text-sm font-medium transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                    @endif

                    <div class="flex items-center gap-1 mx-2">
                        @foreach ($colis->getUrlRange(max(1, $colis->currentPage() - 2), min($colis->lastPage(), $colis->currentPage() + 2)) as $page => $url)
                            @if ($page == $colis->currentPage())
                                <span class="inline-flex items-center justify-center min-w-[2.25rem] h-9 px-3 rounded-lg bg-indigo-600 text-white text-sm font-semibold">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="inline-flex items-center justify-center min-w-[2.25rem] h-9 px-3 rounded-lg text-slate-600 hover:bg-slate-100 text-sm font-medium transition-all duration-200">{{ $page }}</a>
                            @endif
                        @endforeach
                    </div>

                    @if ($colis->hasMorePages())
                        <a href="{{ $colis->nextPageUrl() }}" class="inline-flex items-center px-3 py-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 text-sm font-medium transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <span class="inline-flex items-center px-3 py-2 rounded-lg text-slate-400 cursor-not-allowed text-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    @endif
                </nav>
                <p class="ml-4 text-sm text-slate-500 hidden sm:block">
                    Page {{ $colis->currentPage() }} sur {{ $colis->lastPage() }}
                </p>
            </div>
            @endif
        </div>

        {{-- Top Clients --}}
        @if(!empty($topClients) && $topClients->isNotEmpty())
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Top Clients</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach($topClients as $client)
                    <a href="{{ route('clients.show', $client->id) }}" class="block p-4 rounded-xl bg-slate-50/50 border border-slate-100 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all duration-200 group">
                        <p class="font-semibold text-slate-900 group-hover:text-indigo-700">{{ $client->nom }}</p>
                        <p class="text-sm text-slate-500 mt-1">{{ $client->colis_count ?? 0 }} colis envoyés</p>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Modale QR --}}
        <div id="qr-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4" aria-hidden="true">
            <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 border border-slate-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-slate-800">QR Code — Étiquette</h3>
                    <button type="button" id="qr-modal-close" class="p-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors" aria-label="Fermer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex flex-col items-center gap-4 mb-5">
                    <div id="qr-modal-svg" class="[&>svg]:w-48 [&>svg]:h-48 p-4 bg-white rounded-xl border border-slate-100"></div>
                    <p id="qr-modal-code" class="font-mono text-sm text-slate-600"></p>
                </div>
                <div class="flex gap-2">
                    <button type="button" id="qr-modal-print" class="flex-1 bg-indigo-600 text-white font-medium px-4 py-2.5 rounded-xl hover:bg-indigo-700 transition-colors">Imprimer</button>
                    <button type="button" id="qr-modal-newtab" class="flex-1 bg-slate-100 text-slate-700 font-medium px-4 py-2.5 rounded-xl hover:bg-slate-200 transition-colors">Nouvel onglet</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Recherche en temps réel (debounce 400ms)
        const searchForm = document.getElementById('search-form');
        const searchInput = document.getElementById('search-input');
        let searchTimeout;
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => searchForm.submit(), 400);
            });
        }

        const modal = document.getElementById('qr-modal');
        const modalSvg = document.getElementById('qr-modal-svg');
        const modalCode = document.getElementById('qr-modal-code');
        const btnClose = document.getElementById('qr-modal-close');
        const btnPrint = document.getElementById('qr-modal-print');
        const btnNewTab = document.getElementById('qr-modal-newtab');

        document.querySelectorAll('.qr-thumb').forEach(btn => {
            btn.addEventListener('click', function() {
                const colisId = this.dataset.colisId;
                const code = this.dataset.code || colisId;
                const template = document.getElementById('qr-template-' + colisId);
                if (template) {
                    modalSvg.innerHTML = template.innerHTML;
                    modalCode.textContent = code;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }
            });
        });

        btnClose.addEventListener('click', () => { modal.classList.add('hidden'); modal.classList.remove('flex'); });
        btnPrint.addEventListener('click', function() {
            const w = window.open('', '_blank');
            w.document.write('<html><head><title>QR ' + modalCode.textContent + '</title><style>body{display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:100vh;margin:0;font-family:system-ui,sans-serif}</style></head><body><div style="width:200px;height:200px">' + modalSvg.innerHTML + '</div><p style="font-family:monospace;margin-top:1rem;font-size:14px;color:#475569">' + modalCode.textContent + '</p></body></html>');
            w.document.close();
            w.focus();
            w.print();
            w.close();
        });
        btnNewTab.addEventListener('click', function() {
            const svg = modalSvg.innerHTML;
            const code = modalCode.textContent;
            const w = window.open('', '_blank');
            w.document.write('<html><head><title>QR ' + code + '</title></head><body style="display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:100vh;margin:0;"><div style="width:200px;height:200px">' + svg + '</div><p style="font-family:monospace;margin-top:1rem;color:#475569">' + code + '</p></body></html>');
            w.document.close();
        });
    });
    </script>
</x-app-layout>
