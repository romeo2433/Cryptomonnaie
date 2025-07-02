@extends('layouts.opp')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1>Liste des Utilisateurs</h1>

    <div class="row">
        @foreach($users as $user)
            <div class="col-md-3 mb-4">
                <div class="card text-center">
                    <a href="{{ route('admin.users.show', $user->id) }}">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('image/default.jpg') }}" 
                             class="card-img-top rounded-circle" 
                             alt="{{ $user->name }}" 
                             style="width: 100px; height: 100px; object-fit: cover; margin: auto;">
                    </a>

                    <div class="card-body">
                        <h5 class="card-title">{{ $user->name }}</h5>

                        <!-- Bouton pour voir l'historique des transactions -->
                        <a href="{{ route('admin.users.historique', $user->id) }}" class="btn btn-info btn-sm">
                            Voir l'historique des transactions
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
