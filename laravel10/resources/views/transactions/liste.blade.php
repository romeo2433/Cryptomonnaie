@extends('layouts.app')

@section('title', 'Mon Dashboard')

@section('content')
<h1 class="page-title">Transactions de Cryptomonnaies</h1>

<div class="box-container">
    <!-- Section Achats -->
    <section class="transactions-section">
        <h2 class="section-title">Achats</h2>
        <table class="purchase-table">
            <thead>
                <tr>
                    <th>Cryptomonnaie</th>
                    <th>Quantité</th>
                    <th>Montant</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($achats as $achat)
                <tr>
                    <td>{{ $achat->cryptomonnaie_nom }}</td>
                    <td>{{ number_format(abs($achat->quantite), 8) }}</td>
                    <td class="montant">{{ number_format($achat->montant, 2) }} $</td>
                    <td>{{ $achat->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-message">Aucun achat enregistré.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <!-- Section Ventes -->
    <section class="transactions-section">
        <h2 class="section-title">Ventes</h2>
        <table class="purchase-table">
            <thead>
                <tr>
                    <th>Cryptomonnaie</th>
                    <th>Quantité</th>
                    <th>Montant</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ventes as $vente)
                <tr>
                    <td>{{ $vente->cryptomonnaie_nom }}</td>
                    <td>{{ number_format($vente->quantite, 8) }}</td>
                    <td class="montant">{{ number_format($vente->montant, 2) }}  $</td>
                    <td>{{ $vente->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-message">Aucune vente enregistrée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <a href="{{ route('portefeuille.dashboard') }}" class="btn btn-warning">OK</a>
</div>
@endsection
