@extends('layouts.app')

@section('title', 'Mon Dashboard')

@section('content')
    <div class="dashboard-content">
        <h1 class="welcome-message">Bienvenue, {{ $user->name }} !</h1>
        <p class="user-info"><strong>Email :</strong> {{ $user->email }}</p>
        <p class="user-info"><strong>Créé le :</strong> {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</p>

        <h1>Solde actuel : {{ number_format($portefeuille->solde, 2) }} $</h1>

        <hr>

        <h2>Cours des Cryptomonnaies</h2>
        <table class="crypto-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Symbole</th>
                    <th>Prix</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coursCryptomonnaies as $cours)
                    <tr>
                        <td>{{ $cours->cryptomonnaie->nom }}</td>
                        <td>{{ $cours->cryptomonnaie->symbole }}</td>
                        <td>{{ number_format($cours->prix, 2) }} $</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr>
    </div>
@endsection
