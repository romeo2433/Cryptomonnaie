@extends('layouts.app')

@section('title', 'Mon Dashboard')

@section('content')
@if(isset($analyseResults['achat']))
    <h3>Analyse des Achats</h3>
    @foreach($analyseResults['achat'] as $cryptoName => $result)
        <h4>{{ $cryptoName }}</h4>
        <p>Prix d'achat max : {{ $result['prix_achat_max'] }}</p>
        <p>Prix d'achat min : {{ $result['prix_achat_min'] }}</p>
        <p>Prix d'achat moyen : {{ $result['prix_achat_moyenne'] }}</p>
        <p>Total quantité : {{ $result['total_quantite'] }}</p>
        <p>Total montant : {{ $result['total_montant'] }}</p>
    @endforeach
@endif

@if(isset($analyseResults['vente']))
    <h3>Analyse des Ventes</h3>
    @foreach($analyseResults['vente'] as $cryptoName => $result)
        <h4>{{ $cryptoName }}</h4>
        <p>Prix de vente max : {{ $result['prix_achat_max'] }}</p>
        <p>Prix de vente min : {{ $result['prix_achat_min'] }}</p>
        <p>Prix de vente moyen : {{ $result['prix_achat_moyenne'] }}</p>
        <p>Total quantité : {{ $result['total_quantite'] }}</p>
        <p>Total montant : {{ $result['total_montant'] }}</p>
    @endforeach
@endif
@endsection