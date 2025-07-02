@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Vendre une cryptomonnaie</h1>

    @if($achats->isEmpty())
        <p>Vous n'avez aucune cryptomonnaie à vendre.</p>
    @else
        <form action="{{ route('vente.vendre') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="cryptomonnaie_id">Choisir une cryptomonnaie</label>
                <select name="cryptomonnaie_id" id="cryptomonnaie_id" class="form-control" required>
                    @foreach($achats as $achat)
                        <option value="{{ $achat->cryptomonnaie_id }}">
                            {{ $achat->cryptomonnaie->nom }} (Quantité : {{ number_format($achat->quantite, 8) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantite">Quantité à vendre</label>
                <input type="number" name="quantite" id="quantite" class="form-control" step="0.00000001" min="0.00000001" required>
            </div>

            <button type="submit" class="btn btn-primary">Vendre</button>
        </form>
    @endif
</div>
@endsection
