@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Tableau de bord des colis</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Colis</th>
                <th>Description</th>
                <th>Poids (kg)</th>
                <th>Statut</th>
                <th>Date de réception</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {{-- Exemple de données statiques --}}
            <tr>
                <td>1</td>
                <td>Colis fragile</td>
                <td>2.5</td>
                <td>En transit</td>
                <td>2023-10-01</td>
                <td>
                    <a href="#" class="btn btn-info btn-sm">Détails</a>
                    <a href="#" class="btn btn-warning btn-sm">Modifier</a>
                </td>
            </tr>
            {{-- Ajouter une boucle ici pour afficher les données dynamiques --}}
        </tbody>
    </table>
</div>
@endsection
