@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achat de Cryptomonnaies</title>

    <!-- Intégration de Bootstrap pour un style rapide -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
        
    <div class="form-container">
        <h1>Achat de Cryptomonnaies</h1>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('achat.acheter') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="cryptomonnaie_id">Choisissez une cryptomonnaie :</label>
                <select name="cryptomonnaie_id" id="cryptomonnaie_id" required>
                    @foreach ($cours as $c)
                        <option value="{{ $c->cryptomonnaie_id }}">
                            {{ $c->cryptomonnaie->nom }} - {{ number_format($c->prix, 2) }} USD
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="montant">Entrez votre montant (USD) :</label>
                <input type="number" name="montant" id="montant" step="0.01" required>
            </div>

            <button type="submit">Acheter</button>
        </form>
    </div>

</body>
</html>
@endsection
