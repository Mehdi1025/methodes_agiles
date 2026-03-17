<x-app-layout>
    <x-slot name="header">Scanner QR</x-slot>

    <div class="max-w-lg mx-auto">
        {{-- Carte principale --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200/80">
            <div class="px-8 py-10 text-center">
                <div class="inline-flex p-4 bg-indigo-100 rounded-2xl mb-6">
                    <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-800 mb-2">Réception rapide par QR Code</h2>
                <p class="text-slate-500 text-sm mb-8 max-w-sm mx-auto">Scannez le QR Code d'un colis pour le créer ou le retrouver en un instant.</p>

                <div class="flex flex-wrap justify-center gap-3">
                    <button type="button" id="btn-open-camera"
                        class="inline-flex items-center gap-3 px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 border border-indigo-500/20 active:scale-[0.98]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13v7a2 2 0 01-2 2H7a2 2 0 01-2-2v-7"/>
                        </svg>
                        Lancer le scan
                    </button>
                    <button type="button" id="btn-import-image"
                        class="inline-flex items-center gap-3 px-6 py-4 bg-white hover:bg-slate-50 text-slate-700 font-semibold rounded-xl shadow-lg border border-slate-200 hover:border-slate-300 transition-all duration-200 active:scale-[0.98]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Importer une image
                    </button>
                </div>
            </div>

            <input type="file" id="scan-file-input" accept="image/*" class="hidden">
            <div id="reader-wrapper" class="relative mx-4 mb-4 rounded-2xl overflow-hidden bg-slate-900 min-h-[280px]">
                <div id="reader" class="rounded-2xl [&>div]:rounded-2xl [&>video]:rounded-2xl min-h-[280px] hidden"></div>
                <div id="reader-drag-hint" class="absolute inset-0 hidden items-center justify-center bg-slate-800/90 rounded-2xl border-2 border-dashed border-indigo-400/50 z-10 pointer-events-none">
                    <p class="text-white/90 text-sm font-medium">Déposez ici une image</p>
                </div>
                <div id="reader-import-placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-slate-400 text-sm">
                    <svg class="w-10 h-10 mb-2 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/></svg>
                    <p>Glissez-déposez une image ou cliquez sur Importer</p>
                </div>
                {{-- HUD Scanner (visible quand caméra active) --}}
                <div id="viewfinder-overlay" class="absolute inset-0 pointer-events-none hidden flex-col items-center justify-center">
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
                <div id="viewfinder-mask" class="absolute inset-0 pointer-events-none rounded-2xl hidden" style="background: radial-gradient(ellipse 140px 140px at 50% 42%, transparent 0%, rgba(0,0,0,0.7) 100%);"></div>
                <div id="scan-flash-overlay" class="absolute inset-0 pointer-events-none rounded-2xl bg-emerald-500/30 opacity-0 transition-opacity duration-300"></div>
                <div id="scan-confirm-card" class="absolute inset-x-4 bottom-4 z-30 hidden flex-col p-4 rounded-2xl bg-white/95 backdrop-blur-md shadow-2xl border border-slate-200/80">
                    <p class="text-xs font-medium text-slate-500 mb-1">Code détecté</p>
                    <p id="scan-confirm-code" class="font-mono font-bold text-slate-900 text-lg mb-4 truncate"></p>
                    <div class="flex gap-3">
                        <button type="button" id="btn-scan-validate" class="flex-1 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">Valider</button>
                        <button type="button" id="btn-scan-retry" class="flex-1 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition-colors">Scanner à nouveau</button>
                    </div>
                </div>
            </div>
            <div id="scanner-controls" class="mx-4 mt-3 hidden flex justify-center gap-2">
                <button type="button" id="btn-torch" class="hidden p-3 rounded-xl bg-slate-100/80 hover:bg-slate-200/80 backdrop-blur-sm text-slate-600 transition-all" aria-label="Torche" title="Torche">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                </button>
                <button type="button" id="btn-switch-camera" class="p-3 rounded-xl bg-slate-100/80 hover:bg-slate-200/80 backdrop-blur-sm text-slate-600 transition-all" aria-label="Changer de caméra"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg></button>
                <button type="button" id="btn-sound-toggle" class="p-3 rounded-xl bg-slate-100/80 hover:bg-slate-200/80 backdrop-blur-sm text-slate-600 transition-all" aria-label="Son">
                    <svg id="icon-sound-on" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/></svg>
                    <svg id="icon-sound-off" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/></svg>
                </button>
            </div>
            <div id="scanner-error" class="mx-4 mb-4 hidden p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span></span>
            </div>
            <div id="scanner-success" class="mx-4 mb-4 hidden p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span></span>
            </div>
        </div>

        <p class="mt-6 text-center text-xs text-slate-400">
            Utilisez la caméra de votre appareil pour scanner un QR Code.
            <a href="{{ route('scanner.test-qr') }}" class="text-indigo-600 hover:underline font-medium">Obtenir un QR Code de test</a>
        </p>
    </div>

    <style>
    @keyframes viewfinder-pulse { 0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4); } 50% { opacity: 0.8; box-shadow: 0 0 20px 2px rgba(99, 102, 241, 0.3); } }
    .viewfinder-pulse { animation: viewfinder-pulse 2s ease-in-out infinite; }
    @keyframes fade-pulse { 0%, 100% { opacity: 0.9; } 50% { opacity: 0.6; } }
    .animate-fade-pulse { animation: fade-pulse 2s ease-in-out infinite; }
    @keyframes laser-sweep { 0%, 100% { top: 5%; } 50% { top: 95%; } }
    .laser-sweep { animation: laser-sweep 2s ease-in-out infinite; }
    </style>

<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnOpen = document.getElementById('btn-open-camera');
    const btnImport = document.getElementById('btn-import-image');
    const fileInput = document.getElementById('scan-file-input');
    const readerDiv = document.getElementById('reader');
    const readerWrapper = document.getElementById('reader-wrapper');
    const readerPlaceholder = document.getElementById('reader-import-placeholder');
    const readerDragHint = document.getElementById('reader-drag-hint');
    const viewfinderOverlay = document.getElementById('viewfinder-overlay');
    const viewfinderMask = document.getElementById('viewfinder-mask');
    const scanFlashOverlay = document.getElementById('scan-flash-overlay');
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
    const errorEl = document.getElementById('scanner-error');
    const successEl = document.getElementById('scanner-success');

    let html5QrCode = null;
    let isScanning = false;
    let isProcessingFile = false;
    let soundEnabled = true;
    let currentFacingMode = 'environment';
    let pendingScannedCode = null;

    function triggerHaptic() {
        if (navigator.vibrate) navigator.vibrate([200, 100, 200]);
    }

    function playBeep() {
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

    function showSuccess(msg) {
        successEl.querySelector('span').textContent = msg;
        successEl.classList.remove('hidden');
        errorEl.classList.add('hidden');
    }

    function showError(msg) {
        errorEl.querySelector('span').textContent = msg;
        errorEl.classList.remove('hidden');
        successEl.classList.add('hidden');
    }

    function stopScanner() {
        if (html5QrCode && isScanning) {
            return html5QrCode.stop().then(() => {
                isScanning = false;
                html5QrCode = null;
                viewfinderOverlay.classList.add('hidden');
                viewfinderOverlay.classList.remove('flex');
                viewfinderMask.classList.add('hidden');
                scannerControls.classList.add('hidden');
            }).catch(() => {
                isScanning = false;
                viewfinderOverlay.classList.add('hidden');
                viewfinderMask.classList.add('hidden');
                scannerControls.classList.add('hidden');
            });
        }
        return Promise.resolve();
    }

    function validateScannedCode() {
        if (pendingScannedCode) {
            if (soundEnabled) playBeep();
            triggerHaptic();
            stopScanner();
            showSuccess('Code scanné ! Redirection...');
            window.location.href = '{{ route("colis.lookup") }}?code_qr=' + encodeURIComponent(pendingScannedCode);
        }
    }

    function resumeScanning() {
        pendingScannedCode = null;
        scanConfirmCard.classList.add('hidden');
        scanConfirmCard.classList.remove('flex');
        if (html5QrCode && html5QrCode.getState() === 2) html5QrCode.resume();
    }

    function onScanSuccess(decodedText) {
        if (pendingScannedCode) return;
        pendingScannedCode = decodedText;
        if (html5QrCode && isScanning) html5QrCode.pause();
        if (soundEnabled) playBeep();
        triggerHaptic();
        scanFlashOverlay.classList.remove('opacity-0');
        scanFlashOverlay.classList.add('opacity-100');
        setTimeout(() => {
            scanFlashOverlay.classList.remove('opacity-100');
            scanFlashOverlay.classList.add('opacity-0');
        }, 300);
        scanConfirmCode.textContent = decodedText;
        scanConfirmCard.classList.remove('hidden');
        scanConfirmCard.classList.add('flex');
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
        viewfinderOverlay.classList.add('hidden');
        viewfinderMask.classList.add('hidden');
        scannerControls.classList.add('hidden');
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
            viewfinderOverlay.classList.remove('hidden');
            viewfinderOverlay.classList.add('flex');
            viewfinderMask.classList.remove('hidden');
            scannerControls.classList.remove('hidden');
            btnTorch.classList.add('hidden');
            try {
                const caps = html5QrCode.getRunningTrackCameraCapabilities();
                const torch = caps && typeof caps.torchFeature === 'function' ? caps.torchFeature() : null;
                if (torch && typeof torch.apply === 'function') btnTorch.classList.remove('hidden');
            } catch (e) { /* torch non supporté */ }
        } catch (e) {
            currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
            showError('Impossible de changer de caméra.');
        }
    }

    async function processFile(file) {
        if (!file || !file.type.startsWith('image/')) return;
        if (isProcessingFile) return;
        isProcessingFile = true;
        errorEl.classList.add('hidden');
        successEl.classList.add('hidden');
        readerDragHint.classList.add('hidden');
        readerDragHint.classList.remove('flex');
        readerPlaceholder.classList.add('hidden');
        readerPlaceholder.classList.remove('flex');

        const scanWithFile = async () => {
            try {
                if (isScanning) await stopScanner();
                readerDiv.innerHTML = '';
                readerDiv.classList.remove('hidden');
                const scanner = new Html5Qrcode('reader');
                const decodedText = await scanner.scanFile(file, false);
                onScanSuccess(decodedText);
            } catch (err) {
                showError('Aucun QR Code détecté dans cette image');
                readerPlaceholder.classList.remove('hidden');
                readerPlaceholder.classList.add('flex');
            } finally {
                isProcessingFile = false;
                fileInput.value = '';
            }
        };
        await scanWithFile();
    }

    async function startScanner() {
        if (isScanning) return;
        errorEl.classList.add('hidden');
        successEl.classList.add('hidden');
        readerDiv.innerHTML = '';
        readerDiv.classList.remove('hidden');
        readerPlaceholder.classList.add('hidden');
        readerPlaceholder.classList.remove('flex');

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            showError('Votre navigateur ou appareil ne supporte pas l\'accès à la caméra.');
            readerPlaceholder.classList.remove('hidden');
            readerPlaceholder.classList.add('flex');
            return;
        }

        try {
            html5QrCode = new Html5Qrcode('reader');
            await html5QrCode.start(
                { facingMode: currentFacingMode },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                onScanSuccess,
                () => {}
            );
            isScanning = true;
            viewfinderOverlay.classList.remove('hidden');
            viewfinderOverlay.classList.add('flex');
            viewfinderMask.classList.remove('hidden');
            scannerControls.classList.remove('hidden');
            btnTorch.classList.add('hidden');
            try {
                const caps = html5QrCode.getRunningTrackCameraCapabilities();
                const torch = caps && typeof caps.torchFeature === 'function' ? caps.torchFeature() : null;
                if (torch && typeof torch.apply === 'function') btnTorch.classList.remove('hidden');
            } catch (e) { /* torch non supporté */ }
        } catch (err) {
            showError('Impossible d\'accéder à la caméra : ' + (err.message || 'Vérifiez les permissions.'));
            readerPlaceholder.classList.remove('hidden');
            readerPlaceholder.classList.add('flex');
        }
    }

    btnOpen.addEventListener('click', startScanner);
    btnImport.addEventListener('click', () => fileInput.click());
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
});
</script>
</x-app-layout>
