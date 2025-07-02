
@extends('layouts.opp')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1>Transactions</h1>

    <!-- Formulaire de filtre -->
    <form method="GET" action="{{ route('transactions.index') }}">
        <div class="form-row">
            <!-- Filtre par utilisateur -->
            <div class="form-group col-md-4">
                <label for="user_id">Filtrer par utilisateur:</label>
                <select name="user_id" id="user_id" class="form-control">
                    <option value="">Tous les utilisateurs</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

             <!-- Filtre par cryptomonnaie -->
             <div class="form-group col-md-3">
                <label for="cryptomonnaie_id">Cryptomonnaie:</label>
                <select name="cryptomonnaie_id" id="cryptomonnaie_id" class="form-control">
                    <option value="">Toutes les cryptomonnaies</option>
                    @foreach($cryptomonnaies as $crypto)
                        <option value="{{ $crypto->id }}" {{ request('cryptomonnaie_id') == $crypto->id ? 'selected' : '' }}>{{ $crypto->nom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtre par date de début -->
            <div class="form-group col-md-4">
                <label for="start_date">Date de début:</label>
                <input type="datetime-local" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>

            <!-- Filtre par date de fin -->
            <div class="form-group col-md-4">
                <label for="end_date">Date de fin:</label>
                <input type="datetime-local" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Filtrer</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Réinitialiser</a>
    </form>

    <!-- Tableau des transactions -->
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Cryptomonnaie</th>
                <th>Quantité</th>
                <th>Montant</th>
                <th>Prix d'achat</th>
                <th>Date</th>
                <th>Date</th>

            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ $transaction->cryptomonnaie->nom }}</td>
                    <td>{{ $transaction->quantite }}</td>
                    <td>{{ $transaction->montant }}</td>
                    <td>{{ $transaction->prix_achat }}</td>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $transaction->type }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
