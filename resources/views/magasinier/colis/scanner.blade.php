<x-app-layout>
    {{-- Overlay de Flash (caché) --}}
    <div id="flash-overlay" class="fixed inset-0 bg-emerald-500 z-50 opacity-0 pointer-events-none transition-opacity duration-200"></div>

    {{-- Élément Audio (caché) --}}
    <audio id="scan-beep" src="https://www.soundjay.com/buttons/sounds/beep-07a.mp3" preload="auto"></audio>

    <div class="max-w-2xl mx-auto mt-12">
        <div class="bg-zinc-900 p-8 rounded-3xl shadow-2xl border border-zinc-800 text-center">
            <div class="mb-6 flex justify-center">
                <svg class="w-16 h-16 text-indigo-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-white mb-2">Terminal de Réception</h2>
            <p class="text-zinc-400 mb-8">Scannez le code-barres du colis ou saisissez la référence manuellement.</p>

            <form id="scanner-form" onsubmit="handleScan(event)">
                <input type="text"
                       id="barcode-input"
                       class="w-full bg-zinc-950 border-2 border-zinc-700 text-white text-3xl font-mono font-bold text-center py-6 rounded-2xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all uppercase placeholder-zinc-700"
                       placeholder="SCANNEZ ICI..."
                       autocomplete="off"
                       autofocus
                       required>
            </form>
        </div>

        <div class="mt-8 space-y-4" id="scanned-items-list"></div>
    </div>

    <script>
        // Toujours garder le focus sur le champ pour la douchette
        document.addEventListener('click', function(e) {
            if (e.target.id !== 'barcode-input') {
                document.getElementById('barcode-input').focus();
            }
        });

        function handleScan(event) {
            event.preventDefault();

            const input = document.getElementById('barcode-input');
            const reference = input.value.trim().toUpperCase();
            if (!reference) return;

            input.disabled = true;

            fetch('{{ route("magasinier.colis.scan") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ reference: reference })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('scan-beep').play().catch(e => console.log('Audio error:', e));

                    const flash = document.getElementById('flash-overlay');
                    flash.classList.replace('opacity-0', 'opacity-30');
                    setTimeout(() => flash.classList.replace('opacity-30', 'opacity-0'), 150);

                    const refDisplay = data.colis.reference || reference;
                    const cardHtml = `
                        <div class="bg-white border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm flex items-center justify-between transform transition-all duration-300 translate-y-[-20px] opacity-0" id="card-${data.colis.id}">
                            <div class="flex items-center gap-4">
                                <div class="bg-emerald-100 p-2 rounded-full">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 font-mono text-lg">#${refDisplay}</h4>
                                    <p class="text-sm text-slate-500">Réceptionné à ${new Date().toLocaleTimeString('fr-FR')}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full uppercase">En stock</span>
                        </div>
                    `;

                    const list = document.getElementById('scanned-items-list');
                    list.insertAdjacentHTML('afterbegin', cardHtml);

                    setTimeout(() => {
                        const newCard = list.firstElementChild;
                        newCard.classList.remove('translate-y-[-20px]', 'opacity-0');
                    }, 10);
                } else {
                    alert(data.message || 'Erreur lors de la réception.');
                }
            })
            .catch(() => {
                alert('Erreur de connexion. Vérifiez votre réseau.');
            })
            .finally(() => {
                input.value = '';
                input.disabled = false;
                input.focus();
            });
        }
    </script>
</x-app-layout>
