@extends('layouts.opp')

@section('title', 'Dashboard')

@section('content')
<div class="main-content">
    <h1>Historique des transactions de {{ $user->name }}</h1>
    <div class="container">
    <h1>Profil de {{ $user->name }}</h1>

    <!-- Affichage de l'avatar -->
    <div class="text-center">
        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('image/romeo.jpg') }}" 
             class="rounded-circle" 
             alt="{{ $user->name }}" 
             style="width: 150px; height: 150px; object-fit: cover;">
    </div>

    <!-- Formulaire de mise à jour de l'avatar -->
    <form action="{{ route('admin.users.update_avatar', $user->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="avatar" class="form-label">Changer l'avatar :</label>
            <input type="file" name="avatar" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        
    </form>
    @if(session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
        @endif
</div>


    <table class="table">
        <thead>
            <tr>
                <th>Cryptomonnaie</th>
                <th>Quantité</th>
                <th>Montant</th>
                <th>Prix d'achat</th>
                <th>Date</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user->transactions as $transaction)
                <tr>
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
</div>