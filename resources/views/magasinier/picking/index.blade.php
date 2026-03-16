<x-app-layout>
    <div class="max-w-4xl mx-auto">
        {{-- En-tête et Barre de Progression (Sticky) --}}
        <header class="sticky top-0 z-10 bg-zinc-50/90 backdrop-blur-md pb-6 pt-4 border-b border-zinc-200 mb-8 -mx-6 px-6">
            <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">
                📋 Mission de Picking
                <span id="mission-count" class="text-indigo-600">{{ $colisAPreparer->count() }}</span>
                <span class="text-zinc-500 font-normal text-lg">colis à préparer</span>
            </h1>

            <div class="mt-4">
                <div class="flex justify-between text-sm font-medium text-zinc-500 mb-2">
                    <span>Progression globale</span>
                    <span id="progress-text">0%</span>
                </div>
                <div class="w-full bg-zinc-200 rounded-full h-3 overflow-hidden shadow-inner">
                    <div id="progress-bar" class="bg-indigo-600 h-3 rounded-full transition-all duration-700 ease-out" style="width: 0%"></div>
                </div>
            </div>
        </header>

        {{-- Liste des Tâches (Les Colis) --}}
        <section class="space-y-4">
            @forelse ($colisAPreparer as $colis)
                @php
                    $emplacementLabel = $colis->emplacement
                        ? "Zone {$colis->emplacement->zone} - Allée {$colis->emplacement->allee}"
                        : 'Emplacement non assigné';
                @endphp
                <div class="task-card group flex items-center justify-between p-5 bg-white border border-zinc-200 rounded-2xl cursor-pointer hover:border-indigo-400 hover:shadow-md transition-all duration-500 ease-in-out"
                     data-id="{{ $colis->id }}"
                     data-pick-url="{{ route('magasinier.picking.pick', $colis) }}"
                     onclick="markAsPicked(this)">
                    <div class="flex items-center flex-1 min-w-0">
                        <div class="check-circle w-6 h-6 rounded-full border-2 border-zinc-300 group-hover:border-indigo-500 flex-shrink-0 mr-4 transition-colors flex items-center justify-center">
                        </div>
                        <div class="min-w-0">
                            <p class="task-title font-bold text-zinc-900 truncate transition-colors">
                                {{ $colis->code_qr ?? 'Colis #' . Str::limit($colis->id, 8) }}
                            </p>
                            <p class="text-sm text-zinc-500 truncate">{{ $emplacementLabel }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0 ml-4">
                        @if ($colis->fragile)
                            <span class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-800 rounded-lg">⚠️ Fragile</span>
                        @endif
                        <span class="px-2 py-1 text-xs font-medium bg-zinc-100 text-zinc-600 rounded-lg">{{ number_format($colis->poids_kg, 1) }} kg</span>
                        <button type="button"
                                onclick="event.stopPropagation(); openAnomalyModal(@json($colis->id), @json($colis->code_qr ?? '#' . Str::limit($colis->id, 8)), @json(route('magasinier.picking.anomalie', $colis)))"
                                class="ml-4 p-2 text-zinc-300 hover:text-red-500 hover:bg-red-50 rounded-full transition-colors focus:outline-none"
                                title="Signaler un problème">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-16 px-6 rounded-2xl bg-zinc-50 border border-zinc-200 border-dashed">
                    <span class="text-4xl mb-4">✅</span>
                    <p class="text-zinc-600 font-medium">Aucun colis à préparer</p>
                    <p class="text-sm text-zinc-500 mt-1">Tous les colis en stock ont été pris en charge.</p>
                </div>
            @endforelse
        </section>

        {{-- Modale Signalement d'Anomalie (affichée uniquement s'il y a des colis) --}}
        @if ($colisAPreparer->isNotEmpty())
        <div id="anomaly-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
            <div class="absolute inset-0 bg-red-950/40 backdrop-blur-sm" onclick="closeAnomalyModal()"></div>

            <div class="relative bg-zinc-900 border border-red-500/30 rounded-2xl shadow-2xl w-full max-w-md p-6 transform scale-95 transition-transform duration-300" id="anomaly-modal-content">
                <div class="flex items-center gap-3 text-red-500 mb-4">
                    <svg class="w-8 h-8 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-white">Signaler une anomalie</h3>
                </div>

                <p class="text-zinc-400 text-sm mb-6">Que se passe-t-il avec le colis <span id="anomaly-colis-name" class="font-mono text-zinc-200 font-bold"></span> ?</p>

                <input type="hidden" id="anomaly-colis-id">
                <input type="hidden" id="anomaly-colis-url">

                <div class="space-y-3 mb-6">
                    <label class="flex items-center p-3 border border-zinc-700 rounded-xl cursor-pointer hover:bg-zinc-800 transition-colors">
                        <input type="radio" name="anomaly_reason" value="Colis endommagé" class="text-red-500 focus:ring-red-500 bg-zinc-900 border-zinc-600">
                        <span class="ml-3 text-zinc-200 font-medium">📦 Colis endommagé / écrasé</span>
                    </label>
                    <label class="flex items-center p-3 border border-zinc-700 rounded-xl cursor-pointer hover:bg-zinc-800 transition-colors">
                        <input type="radio" name="anomaly_reason" value="Étiquette illisible" class="text-red-500 focus:ring-red-500 bg-zinc-900 border-zinc-600">
                        <span class="ml-3 text-zinc-200 font-medium">🏷️ Étiquette illisible ou manquante</span>
                    </label>
                    <label class="flex items-center p-3 border border-zinc-700 rounded-xl cursor-pointer hover:bg-zinc-800 transition-colors">
                        <input type="radio" name="anomaly_reason" value="Colis introuvable" class="text-red-500 focus:ring-red-500 bg-zinc-900 border-zinc-600">
                        <span class="ml-3 text-zinc-200 font-medium">❓ Colis introuvable à l'emplacement</span>
                    </label>
                </div>

                <div id="ai-feedback" class="hidden mb-6 p-4 bg-indigo-950/50 border border-indigo-500/30 rounded-xl text-indigo-200 text-sm"></div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeAnomalyModal()" class="px-4 py-2 text-zinc-400 hover:text-white transition-colors text-sm font-medium">Annuler</button>
                    <button type="button" id="btn-submit-anomaly" onclick="submitAnomaly()" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg shadow-lg shadow-red-600/20 transition-all text-sm font-bold flex items-center gap-2">
                        Déclencher l'alerte
                    </button>
                </div>
            </div>
        </div>
        @endif

        @if ($colisAPreparer->isNotEmpty())
        <script>
            let totalTasks = {{ $colisAPreparer->count() }};
            let completedTasks = 0;

            function updateProgress() {
                if (totalTasks === 0) return;
                let percentage = Math.round((completedTasks / totalTasks) * 100);
                document.getElementById('progress-bar').style.width = percentage + '%';
                document.getElementById('progress-text').innerText = percentage + '%';
                document.getElementById('mission-count').innerText = totalTasks - completedTasks;
            }

            function markAsPicked(element) {
                if (element.classList.contains('picked')) return;

                const pickUrl = element.dataset.pickUrl;

                // 1. Appel AJAX silencieux vers le serveur
                fetch(pickUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                // 2. Animation UI immédiate (Effet Awwwards)
                element.classList.add('picked', 'opacity-50', 'scale-[0.98]', 'bg-zinc-50');

                let title = element.querySelector('.task-title');
                title.classList.add('line-through', 'text-zinc-400');

                let circle = element.querySelector('.check-circle');
                circle.classList.remove('border-zinc-300', 'group-hover:border-indigo-500');
                circle.classList.add('bg-emerald-500', 'border-emerald-500');
                circle.innerHTML = '<svg class="w-full h-full text-white p-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>';

                // 3. Mise à jour de la barre
                completedTasks++;
                updateProgress();
            }

            function openAnomalyModal(id, reference, anomalieUrl) {
                document.getElementById('anomaly-colis-id').value = id;
                document.getElementById('anomaly-colis-name').innerText = reference;
                document.getElementById('anomaly-colis-url').value = anomalieUrl;

                document.getElementById('ai-feedback').classList.add('hidden');
                const btn = document.getElementById('btn-submit-anomaly');
                btn.classList.remove('hidden');
                btn.innerHTML = "Déclencher l'alerte";
                btn.disabled = false;
                document.querySelectorAll('input[name="anomaly_reason"]').forEach(radio => radio.checked = false);

                const modal = document.getElementById('anomaly-modal');
                const content = document.getElementById('anomaly-modal-content');

                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    content.classList.remove('scale-95');
                    content.classList.add('scale-100');
                }, 10);
            }

            function closeAnomalyModal() {
                const modal = document.getElementById('anomaly-modal');
                const content = document.getElementById('anomaly-modal-content');

                modal.classList.add('opacity-0');
                content.classList.remove('scale-100');
                content.classList.add('scale-95');

                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            function submitAnomaly() {
                const id = document.getElementById('anomaly-colis-id').value;
                const anomalieUrl = document.getElementById('anomaly-colis-url').value;
                const reasonElement = document.querySelector('input[name="anomaly_reason"]:checked');

                if (!reasonElement) {
                    alert("Veuillez sélectionner une raison.");
                    return;
                }

                const btn = document.getElementById('btn-submit-anomaly');
                btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Envoi...';
                btn.disabled = true;

                fetch(anomalieUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ raison: reasonElement.value })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        btn.classList.add('hidden');

                        const feedback = document.getElementById('ai-feedback');
                        feedback.innerHTML = data.ai_message;
                        feedback.classList.remove('hidden');

                        const card = document.querySelector(`div[data-id="${id}"]`);
                        if (card) {
                            card.classList.add('opacity-50', 'bg-red-50', 'border-red-200');
                            card.onclick = null;

                            if (typeof completedTasks !== 'undefined') {
                                completedTasks++;
                                updateProgress();
                            }
                        }

                        setTimeout(() => closeAnomalyModal(), 3000);
                    }
                })
                .catch(() => {
                    btn.innerHTML = "Déclencher l'alerte";
                    btn.disabled = false;
                    alert("Une erreur est survenue. Veuillez réessayer.");
                });
            }
        </script>
        @endif
    </div>
</x-app-layout>
