@extends('layouts.opp')

@section('title', 'Portefeuille de ' . $portefeuille->user->name)

@section('content')
    <h1>Portefeuille de {{ $portefeuille->user->name }}</h1>
    <p>Solde actuel : {{ number_format($portefeuille->solde, 8) }} BTC</p>

    <!-- Formulaire pour mise à jour du solde -->
    <form action="{{ route('portefeuille.update', ['userId' => $portefeuille->user_id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="solde">Nouveau solde :</label>
            <input type="text" name="solde" id="solde" class="form-control" value="{{ old('solde', $portefeuille->solde) }}" required>
        </div>
        <button type="submit" class="btn btn-success">Mettre à jour</button>
    </form>
@endsection
