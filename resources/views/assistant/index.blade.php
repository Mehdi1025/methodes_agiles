<x-app-layout>
    <div class="flex gap-6 h-[calc(100vh-10rem)] -mx-6 -mb-6 min-h-[500px]">
        {{-- Zone Principale (70%) --}}
        <div class="flex-1 flex flex-col min-w-0 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            {{-- Fenêtre de discussion --}}
            <div id="chat-messages" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50/30">
                {{-- Message de bienvenue --}}
                <div class="flex gap-3" data-role="ai">
                    <div class="shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white text-lg shadow-md">
                        ✨
                    </div>
                    <div class="flex-1 max-w-[85%]">
                        <div class="bg-white rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm border border-gray-100">
                            <p class="text-gray-800 text-sm leading-relaxed">
                                Bonjour ! Je suis votre assistant IA logistique. Posez-moi vos questions sur l'optimisation du stockage, la gestion des expéditions ou les colis fragiles. Comment puis-je vous aider ?
                            </p>
                        </div>
                        <p class="text-xs text-gray-400 mt-1 ml-1">Assistant IA</p>
                    </div>
                </div>
            </div>

            {{-- Zone de saisie --}}
            <div class="p-4 border-t border-gray-100 bg-white">
                <form id="chat-form" class="flex gap-3">
                    @csrf
                    <input type="text"
                           id="message-input"
                           name="message"
                           placeholder="Posez votre question à l'assistant..."
                           maxlength="2000"
                           required
                           class="flex-1 px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all duration-200 text-gray-900 placeholder-gray-400">
                    <button type="submit"
                            id="send-btn"
                            class="shrink-0 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9 2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        {{-- Zone Latérale Droite (30%) - Suggestions --}}
        <div class="w-80 shrink-0 flex flex-col gap-4">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-4">Suggestions d'Optimisation</h3>
                <div class="space-y-3">
                    <button type="button"
                            data-suggestion="Optimiser l'espace de la Zone A"
                            class="suggestion-btn w-full text-left px-4 py-3 rounded-xl bg-gray-50 hover:bg-indigo-50 border border-gray-100 hover:border-indigo-200 text-gray-700 hover:text-indigo-700 text-sm font-medium transition-all duration-200 hover:shadow-md">
                        Optimiser l'espace de la Zone A
                    </button>
                    <button type="button"
                            data-suggestion="Lister les risques sur les colis fragiles"
                            class="suggestion-btn w-full text-left px-4 py-3 rounded-xl bg-gray-50 hover:bg-indigo-50 border border-gray-100 hover:border-indigo-200 text-gray-700 hover:text-indigo-700 text-sm font-medium transition-all duration-200 hover:shadow-md">
                        Lister les risques sur les colis fragiles
                    </button>
                    <button type="button"
                            data-suggestion="Comment réduire le délai moyen ?"
                            class="suggestion-btn w-full text-left px-4 py-3 rounded-xl bg-gray-50 hover:bg-indigo-50 border border-gray-100 hover:border-indigo-200 text-gray-700 hover:text-indigo-700 text-sm font-medium transition-all duration-200 hover:shadow-md">
                        Comment réduire le délai moyen ?
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const form = document.getElementById('chat-form');
            const input = document.getElementById('message-input');
            const messagesContainer = document.getElementById('chat-messages');
            const sendBtn = document.getElementById('send-btn');

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function addMessage(content, role) {
                const div = document.createElement('div');
                div.className = 'flex gap-3' + (role === 'user' ? ' flex-row-reverse' : '');
                div.setAttribute('data-role', role);

                if (role === 'user') {
                    div.innerHTML = `
                        <div class="flex-1 max-w-[85%] flex justify-end">
                            <div class="bg-indigo-600 text-white rounded-2xl rounded-tr-sm px-4 py-3 shadow-md max-w-[90%]">
                                <p class="text-sm leading-relaxed">${escapeHtml(content)}</p>
                            </div>
                        </div>
                    `;
                } else {
                    div.innerHTML = `
                        <div class="shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white text-lg shadow-md">✨</div>
                        <div class="flex-1 max-w-[85%]">
                            <div class="bg-white rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm border border-gray-100">
                                <p class="text-gray-800 text-sm leading-relaxed whitespace-pre-wrap">${escapeHtml(content)}</p>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 ml-1">Assistant IA</p>
                        </div>
                    `;
                }

                messagesContainer.appendChild(div);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            function addLoadingIndicator() {
                const div = document.createElement('div');
                div.id = 'loading-indicator';
                div.className = 'flex gap-3';
                div.innerHTML = `
                    <div class="shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white text-lg shadow-md">✨</div>
                    <div class="flex-1">
                        <div class="bg-white rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm border border-gray-100 inline-flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-gray-600 text-sm">L'IA réfléchit...</span>
                        </div>
                    </div>
                `;
                messagesContainer.appendChild(div);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            function removeLoadingIndicator() {
                const el = document.getElementById('loading-indicator');
                if (el) el.remove();
            }

            async function sendMessage(message) {
                if (!message.trim()) return;

                addMessage(message, 'user');
                input.value = '';
                sendBtn.disabled = true;
                addLoadingIndicator();

                try {
                    const response = await fetch('{{ route("assistant.chat") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ message: message.trim() })
                    });

                    const data = await response.json();
                    removeLoadingIndicator();

                    if (response.ok && data.reply) {
                        addMessage(data.reply, 'ai');
                    } else {
                        addMessage(data.reply || "Une erreur est survenue. Veuillez réessayer.", 'ai');
                    }
                } catch (err) {
                    removeLoadingIndicator();
                    addMessage("Impossible de contacter l'assistant. Vérifiez votre connexion et qu'Ollama est bien lancé.", 'ai');
                } finally {
                    sendBtn.disabled = false;
                }
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                sendMessage(input.value);
            });

            document.querySelectorAll('.suggestion-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const text = this.getAttribute('data-suggestion');
                    input.value = text;
                    input.focus();
                    sendMessage(text);
                });
            });
        })();
    </script>
</x-app-layout>
