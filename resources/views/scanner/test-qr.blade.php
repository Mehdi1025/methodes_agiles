<x-app-layout>
    <x-slot name="header">QR Code de test</x-slot>

    <div class="max-w-md mx-auto text-center">
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-slate-200/80">
            <h2 class="text-lg font-bold text-slate-800 mb-2">Scannez ce QR Code pour tester</h2>
            <p class="text-slate-500 text-sm mb-6">Le code contient : <code class="bg-slate-100 px-2 py-1 rounded font-mono text-indigo-600">{{ $code }}</code></p>
            <div class="inline-block p-4 bg-white rounded-xl border-2 border-slate-200 shadow-inner">
                {!! $qrSvg !!}
            </div>
            <p class="mt-6 text-xs text-slate-400">
                Ouvrez la page <a href="{{ route('scanner.index') }}" class="text-indigo-600 hover:underline">Scanner</a> sur un autre appareil (ou dans un autre onglet) et scannez ce QR Code.
            </p>
        </div>
    </div>
</x-app-layout>
