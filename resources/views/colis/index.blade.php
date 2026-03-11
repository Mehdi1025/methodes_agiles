<!-- d:\projet_methode_agile2\resources\views\colis\index.blade.php -->

@section('content')
<x-layouts.app>
<div class="container">
    <h1 class="mb-4">Gestion des Colis</h1>
    <div class="card">
        <div class="card-header">
            <h5>Liste des Colis</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Colis</th>
                        <th>Client</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colis as $col)
                        <tr>
                            <td>{{ $col['id'] }}</td>
                            <td>{{ $col['client'] }}</td>
                            <td>
                                <span class="badge 
                                    @if($col['statut'] == 'reçu') bg-primary 
                                    @elseif($col['statut'] == 'livré') bg-success 
                                    @else bg-warning @endif">
                                    {{ $col['statut'] }}
                                </span>
                            </td>
                            <td>{{ $col['date'] }}</td>
                            <td>
                                <button class="btn btn-sm btn-info">Détails</button>
                                <button class="btn btn-sm btn-warning">Modifier</button>
                                <button class="btn btn-sm btn-danger">Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-layouts.app>
@endsections
