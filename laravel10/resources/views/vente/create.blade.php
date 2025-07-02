@extends('layouts.app')

@section('title', 'Mon Dashboard')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@section('content')
<div class="container">
    <h1>Vendre une Cryptomonnaie</h1>

    <!-- Formulaire -->
    <form action="{{ route('vente.effectuer') }}" method="POST">
        @csrf <!-- Protection CSRF obligatoire -->
        
        <!-- Sélection de la cryptomonnaie -->
        <div class="mb-3">
            <label for="cryptomonnaie" class="form-label">Sélectionnez une cryptomonnaie :</label>
            <select name="cryptomonnaie_id" id="cryptomonnaie" class="form-select" required>
                @foreach($cryptomonnaies as $cryptomonnaie)
                    <option value="{{ $cryptomonnaie->id }}">
                        {{ $cryptomonnaie->nom }} (Quantité : {{ $cryptomonnaie->total_quantite ?? '0' }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Quantité à vendre -->
        <div class="mb-3">
            <label for="quantite" class="form-label">Quantité à vendre :</label>
            <input type="number" step="0.01" name="quantite" id="quantite" class="form-control" required>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-primary">Vendre</button>
    </form>
</div>
@endsection
