@extends('layouts.app')

@section('title', 'Achat réussi')

@section('content')
    <div class="container">
        <h1>Achat réussi</h1>
        <p>Vous avez acheté <strong>{{ $quantite }}</strong> {{ $cryptomonnaie }} pour un total de <strong>{{ $montant }} USD</strong>.</p>
        <a href="{{ route('achat.index') }}" class="btn btn-primary">Retour</a>
        <a href="{{ route('portefeuille.dashboard') }}" class="btn btn-warning">OK</a>
    </div>
@endsection
