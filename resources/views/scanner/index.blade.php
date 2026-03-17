<x-app-layout>
    <x-slot name="header">Scanner QR</x-slot>
    <div class="bg-white rounded-xl shadow-sm p-8 max-w-md mx-auto">
        <p class="text-gray-600 mb-4">Scannez un QR Code pour l'ajouter à un nouveau colis.</p>
        <button type="button" id="btn-open-camera" class="bg-slate-600 text-white font-medium px-4 py-2 rounded shadow hover:bg-slate-700">
            Ouvrir la caméra
        </button>
        <div id="reader" class="mt-4 rounded-lg overflow-hidden bg-slate-100 hidden"></div>
        <p id="scanner-error" class="mt-3 text-red-500 text-sm hidden"></p>
        <p id="scanner-success" class="mt-3 text-green-600 text-sm font-medium hidden"></p>
    </div>

<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnOpen = document.getElementById('btn-open-camera');
    const readerDiv = document.getElementById('reader');
    const errorEl = document.getElementById('scanner-error');
    const successEl = document.getElementById('scanner-success');

    let html5QrCode = null;
    let isScanning = false;

    function playBeep() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.frequency.value = 800;
            osc.type = 'sine';
            gain.gain.setValueAtTime(0.3, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.2);
            osc.start(ctx.currentTime);
            osc.stop(ctx.currentTime + 0.2);
        } catch (e) { /* fallback silencieux */ }
    }

    function showSuccess(msg) {
        successEl.textContent = msg;
        successEl.classList.remove('hidden');
        errorEl.classList.add('hidden');
    }

    function showError(msg) {
        errorEl.textContent = msg;
        errorEl.classList.remove('hidden');
        successEl.classList.add('hidden');
    }

    async function startScanner() {
        if (isScanning) return;
        errorEl.classList.add('hidden');
        successEl.classList.add('hidden');
        readerDiv.innerHTML = '';
        readerDiv.classList.remove('hidden');

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            showError('Votre navigateur ou appareil ne supporte pas l\'accès à la caméra.');
            return;
        }

        try {
            html5QrCode = new Html5Qrcode('reader');
            await html5QrCode.start(
                { facingMode: 'environment' },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                (decodedText) => {
                    playBeep();
                    showSuccess('✓ Code scanné ! Redirection...');
                    stopScanner();
                    window.location.href = '{{ route("colis.lookup") }}?code_qr=' + encodeURIComponent(decodedText);
                },
                () => {}
            );
            isScanning = true;
        } catch (err) {
            showError('Impossible d\'accéder à la caméra : ' + (err.message || 'Vérifiez les permissions.'));
        }
    }

    function stopScanner() {
        if (html5QrCode && isScanning) {
            html5QrCode.stop().then(() => {
                isScanning = false;
                html5QrCode = null;
            }).catch(() => { isScanning = false; });
        }
    }

    btnOpen.addEventListener('click', startScanner);
});
</script>
</x-app-layout>
