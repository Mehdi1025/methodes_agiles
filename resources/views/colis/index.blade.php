<x-app-layout>
    <div class="space-y-6">
        @if(session('success'))
            <div class="rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-green-800 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- En-tête & Actions --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-bold text-gray-900">Gestion des Colis</h1>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('colis.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouveau Colis
                </a>
                <a href="{{ route('scanner.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    Scanner QR
                </a>
            </div>
        </div>

        {{-- KPIs --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border-l-4 border-l-blue-500 p-6 hover:shadow-md transition-shadow duration-200">
                <p class="text-sm font-medium text-gray-500">Colis total</p>
                <p class="mt-2 text-3xl font-bold text-blue-600">{{ $totalColis ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border-l-4 border-l-emerald-500 p-6 hover:shadow-md transition-shadow duration-200">
                <p class="text-sm font-medium text-gray-500">Livrés</p>
                <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $colisLivres ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border-l-4 border-l-orange-500 p-6 hover:shadow-md transition-shadow duration-200">
                <p class="text-sm font-medium text-gray-500">En cours</p>
                <p class="mt-2 text-3xl font-bold text-orange-600">{{ $colisEnCours ?? 0 }}</p>
            </div>
        </div>

        {{-- Tableau des colis --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Liste des colis</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">QR</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Client</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($colis as $colisItem)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">
                                    {{ Str::limit($colisItem->code_qr ?? $colisItem->id, 14) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button type="button" class="qr-thumb group flex items-center justify-center w-14 h-14 p-1.5 rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-200 bg-white" data-colis-id="{{ $colisItem->id }}" data-code="{{ $colisItem->code_qr ?? $colisItem->id }}" title="Cliquer pour imprimer">
                                        <div class="w-10 h-10 [&>svg]:w-full [&>svg]:h-full opacity-90 group-hover:opacity-100">{!! $colisItem->qr_code_svg_small !!}</div>
                                    </button>
                                    <template id="qr-template-{{ $colisItem->id }}">{!! $colisItem->qr_code_svg !!}</template>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $colisItem->client->nom ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $badgeClasses = match($colisItem->statut) {
                                            'livré' => 'bg-emerald-100 text-emerald-800',
                                            'en_stock' => 'bg-amber-100 text-amber-800',
                                            'en_expédition' => 'bg-orange-100 text-orange-800',
                                            'reçu' => 'bg-blue-100 text-blue-800',
                                            'retour' => 'bg-purple-100 text-purple-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium {{ $badgeClasses }}">
                                        {{ str_replace('_', ' ', ucfirst($colisItem->statut)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $colisItem->date_reception?->format('d/m/Y') ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('colis.show', $colisItem->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Voir</a>
                                        <span class="text-gray-300">|</span>
                                        <a href="{{ route('colis.edit', $colisItem->id) }}" class="text-amber-600 hover:text-amber-800 font-medium text-sm">Modifier</a>
                                        <form action="{{ route('colis.destroy', $colisItem->id) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce colis ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium text-sm">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16">
                                    <div class="flex flex-col items-center justify-center text-center">
                                        <div class="w-16 h-16 mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 font-medium">Aucun colis enregistré</p>
                                        <p class="text-gray-400 text-sm mt-1">Commencez par ajouter votre premier colis</p>
                                        <a href="{{ route('colis.create') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                            Ajouter un colis
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top Clients --}}
        @if(!empty($topClients) && $topClients->isNotEmpty())
        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Clients</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach($topClients as $client)
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <p class="font-semibold text-gray-900">{{ $client->nom }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $client->colis_count ?? 0 }} colis envoyés</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Modale QR pour impression --}}
        <div id="qr-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4" aria-hidden="true">
            <div class="bg-white rounded-xl shadow-xl max-w-sm w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">QR Code — Étiquette</h3>
                    <button type="button" id="qr-modal-close" class="text-gray-500 hover:text-gray-700 p-1 rounded-lg hover:bg-gray-100" aria-label="Fermer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div id="qr-modal-content" class="flex flex-col items-center gap-4 mb-4">
                    <div id="qr-modal-svg" class="[&>svg]:w-48 [&>svg]:h-48 p-4 bg-white rounded-lg"></div>
                    <p id="qr-modal-code" class="font-mono text-sm text-gray-600"></p>
                </div>
                <div class="flex gap-2">
                    <button type="button" id="qr-modal-print" class="flex-1 bg-indigo-600 text-white font-medium px-4 py-2.5 rounded-lg shadow-sm hover:bg-indigo-700 transition-colors">Imprimer</button>
                    <button type="button" id="qr-modal-newtab" class="flex-1 bg-gray-100 text-gray-700 font-medium px-4 py-2.5 rounded-lg hover:bg-gray-200 transition-colors">Nouvel onglet</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
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
            w.document.write('<html><head><title>QR ' + modalCode.textContent + '</title><style>body{display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:100vh;margin:0;font-family:sans-serif}</style></head><body><div style="width:200px;height:200px">' + modalSvg.innerHTML + '</div><p style="font-family:monospace;margin-top:1rem;font-size:14px">' + modalCode.textContent + '</p></body></html>');
            w.document.close();
            w.focus();
            w.print();
            w.close();
        });
        btnNewTab.addEventListener('click', function() {
            const svg = modalSvg.innerHTML;
            const code = modalCode.textContent;
            const w = window.open('', '_blank');
            w.document.write('<html><head><title>QR ' + code + '</title></head><body style="display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:100vh;margin:0;"><div style="width:200px;height:200px">' + svg + '</div><p style="font-family:monospace;margin-top:1rem">' + code + '</p></body></html>');
            w.document.close();
        });
    });
    </script>
</x-app-layout>
