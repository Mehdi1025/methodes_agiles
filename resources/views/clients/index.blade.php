<x-app-layout>
    <x-slot name="header">Clients</x-slot>

    <div class="min-h-screen bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('success'))
                <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200/80 px-4 py-3 text-emerald-800 text-sm font-medium shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-bold text-slate-900">Clients</h1>
                    <span class="bg-slate-200 text-slate-700 rounded-full px-3 py-1 text-sm font-medium">
                        {{ $clients->total() }}
                    </span>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('clients.index') }}" id="search-form" class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="search" name="search" id="search-input" value="{{ request('search') }}"
                               placeholder="Rechercher..."
                               class="pl-10 pr-4 py-2 border border-slate-200 rounded-lg shadow-sm bg-white text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-64">
                    </form>
                    <a href="{{ route('clients.create') }}"
                       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow-sm transition-all font-medium text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Ajouter
                    </a>
                </div>
            </div>

            {{-- Seamless Card Table --}}
            <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-2xl overflow-hidden">
                @if($clients->isEmpty())
                    {{-- Empty State --}}
                    <div class="flex flex-col items-center justify-center py-24 px-6">
                        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <p class="text-slate-600 font-medium">Aucun client pour le moment</p>
                        <a href="{{ route('clients.create') }}"
                           class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Créer mon premier client
                        </a>
                    </div>
                @else
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider py-3 px-6">Client</th>
                                <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider py-3 px-6">Contact</th>
                                <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider py-3 px-6">Activité</th>
                                <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider py-3 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors duration-150">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm shrink-0">
                                                {{ strtoupper(substr($client->prenom ?? '', 0, 1) . substr($client->nom ?? '', 0, 1)) ?: '?' }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-slate-900">{{ $client->prenom }} {{ $client->nom }}</p>
                                                <p class="text-sm text-slate-500">{{ $client->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="text-sm text-slate-500">{{ $client->telephone ?? '—' }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                            {{ $client->colis_count ?? 0 }} Colis
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('clients.show', $client) }}"
                                               class="text-slate-400 hover:text-indigo-600 transition-colors"
                                               title="Voir le profil">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <a href="{{ route('clients.edit', $client) }}"
                                               class="text-slate-400 hover:text-indigo-600 transition-colors"
                                               title="Éditer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- Pagination --}}
            @if($clients->hasPages())
                <div class="mt-6 flex items-center justify-center">
                    <nav class="flex items-center gap-1" aria-label="Pagination">
                        @if ($clients->onFirstPage())
                            <span class="inline-flex items-center px-3 py-2 rounded-lg text-slate-400 cursor-not-allowed text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </span>
                        @else
                            <a href="{{ $clients->previousPageUrl() }}" class="inline-flex items-center px-3 py-2 rounded-lg text-slate-600 hover:bg-slate-100 text-sm transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </a>
                        @endif
                        <span class="px-4 py-2 text-sm text-slate-600 font-medium">
                            Page {{ $clients->currentPage() }} / {{ $clients->lastPage() }}
                        </span>
                        @if ($clients->hasMorePages())
                            <a href="{{ $clients->nextPageUrl() }}" class="inline-flex items-center px-3 py-2 rounded-lg text-slate-600 hover:bg-slate-100 text-sm transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @else
                            <span class="inline-flex items-center px-3 py-2 rounded-lg text-slate-400 cursor-not-allowed text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        @endif
                    </nav>
                </div>
            @endif
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('search-form');
        const input = document.getElementById('search-input');
        if (form && input) {
            let timeout;
            input.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => form.submit(), 400);
            });
        }
    });
    </script>
</x-app-layout>
