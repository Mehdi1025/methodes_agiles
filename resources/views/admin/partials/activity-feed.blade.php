@php
    $typeConfig = [
        'creation' => ['icon' => 'plus', 'border' => 'border-l-emerald-500', 'iconBg' => 'bg-emerald-100', 'iconColor' => 'text-emerald-600'],
        'scan_entree' => ['icon' => 'arrow-down', 'border' => 'border-l-blue-500', 'iconBg' => 'bg-blue-100', 'iconColor' => 'text-blue-600'],
        'scan_sortie' => ['icon' => 'arrow-up', 'border' => 'border-l-indigo-500', 'iconBg' => 'bg-indigo-100', 'iconColor' => 'text-indigo-600'],
        'modification' => ['icon' => 'pencil', 'border' => 'border-l-amber-500', 'iconBg' => 'bg-amber-100', 'iconColor' => 'text-amber-600'],
        'anomalie' => ['icon' => 'alert', 'border' => 'border-l-rose-500', 'iconBg' => 'bg-rose-100', 'iconColor' => 'text-rose-600'],
    ];
    $statutLabels = [
        'reçu' => 'Reçu',
        'en_stock' => 'En stock',
        'en_preparation' => 'En préparation',
        'en_expédition' => 'En transit',
        'livré' => 'Livré',
        'retour' => 'Retour',
        'anomalie' => 'Anomalie',
    ];
@endphp
@forelse($activityFeed as $m)
    @php
        $cfg = $typeConfig[$m->type ?? 'modification'] ?? $typeConfig['modification'];
        $statutLabel = $statutLabels[$m->nouveau_statut ?? ''] ?? str_replace('_', ' ', ucfirst($m->nouveau_statut ?? ''));
        $colisRef = $m->colis ? Str::limit($m->colis->code_qr ?? $m->colis->id, 12) : '—';
        $userName = $m->user?->name ?? 'Système';
        $actions = [
            'creation' => 'a créé le colis',
            'scan_entree' => 'a scanné (entrée) le colis',
            'scan_sortie' => 'a scanné (sortie) le colis',
            'modification' => 'a modifié le colis',
            'anomalie' => 'a signalé une anomalie sur le colis',
        ];
        $actionText = $actions[$m->type ?? 'modification'] ?? 'a modifié le colis';
    @endphp
    @if($m->colis)
    <a href="{{ route('colis.show', $m->colis) }}"
       class="activity-feed-item block border-l-4 {{ $cfg['border'] }} bg-white/50 hover:bg-slate-50 px-4 py-3 transition-colors cursor-pointer">
    @else
    <div class="activity-feed-item block border-l-4 {{ $cfg['border'] }} bg-white/50 px-4 py-3 cursor-default">
    @endif
        <div class="flex items-start gap-3">
            <div class="shrink-0 flex h-9 w-9 items-center justify-center rounded-full {{ $cfg['iconBg'] }}">
                @if($cfg['icon'] === 'plus')
                    <svg class="h-4 w-4 {{ $cfg['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                @elseif($cfg['icon'] === 'arrow-down')
                    <svg class="h-4 w-4 {{ $cfg['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                @elseif($cfg['icon'] === 'arrow-up')
                    <svg class="h-4 w-4 {{ $cfg['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                @elseif($cfg['icon'] === 'pencil')
                    <svg class="h-4 w-4 {{ $cfg['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                @else
                    <svg class="h-4 w-4 {{ $cfg['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-slate-900">
                    <span class="font-semibold">{{ $userName }}</span> {{ $actionText }} <span class="font-mono text-slate-700">#{{ $colisRef }}</span>
                </p>
                <div class="mt-1 flex items-center gap-2 text-xs flex-wrap">
                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                        @if(($m->nouveau_statut ?? '') === 'livré') bg-emerald-100 text-emerald-700
                        @elseif(in_array($m->nouveau_statut ?? '', ['en_expédition', 'en_preparation'])) bg-amber-100 text-amber-700
                        @elseif(in_array($m->nouveau_statut ?? '', ['anomalie', 'retour'])) bg-rose-100 text-rose-700
                        @else bg-slate-100 text-slate-600
                        @endif
                    ">{{ $statutLabel }}</span>
                    <span class="text-slate-400">{{ $m->date_mouvement?->diffForHumans() ?? '—' }}</span>
                </div>
            </div>
        </div>
    @if($m->colis)</a>@else</div>@endif
@empty
    <div class="flex flex-col items-center justify-center px-4 py-12">
        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
            <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <p class="mt-3 text-sm font-medium text-slate-500">Aucune activité récente</p>
        <p class="text-xs text-slate-400">Le flux se met à jour toutes les 30 s</p>
        {{-- Debug : si le flux reste vide après des scans, vérifier que HistoriqueMouvement est bien créé --}}
        <p class="mt-2 text-xs text-amber-600">Aucun mouvement détecté en base.</p>
    </div>
@endforelse
