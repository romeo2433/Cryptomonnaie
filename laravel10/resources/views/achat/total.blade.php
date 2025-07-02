@extends('layouts.app')

@section('title', 'Mon Dashboard')

@section('content')
    <h1 class="title">Totaux des Achats par Cryptomonnaie</h1>

    <!-- Tableau pour afficher les totaux -->
    <table class="totaux-table">
        <thead>
            <tr>
                <th>Cryptomonnaie</th>
                <th>Total Quantité</th>
                <th>Total Montant (USD)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($totaux as $total)
                <tr>
                    <td>{{ $total->cryptomonnaie->nom }}</td> <!-- Nom de la cryptomonnaie -->
                    <td>{{ number_format($total->total_quantite, 8) }}</td> <!-- Total quantité -->
                    <td>{{ number_format($total->total_montant, 2) }} USD</td> <!-- Total montant en USD -->
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('portefeuille.dashboard') }}" class="btn btn-warning">OK</a>
@endsection
