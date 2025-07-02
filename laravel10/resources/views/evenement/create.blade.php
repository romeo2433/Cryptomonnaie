@extends('layouts.app')

@section('title', 'Mon Dashboard')

@section('content')
    <div class="container">
        <h1 class="text-center my-5">Effectuer une Transaction</h1>

        <form action="{{ route('evenement.store') }}" method="POST">
            @csrf
            <div class="form-container">
                
                <!-- Montant -->
                <div class="form-group mb-4">
                    <label for="montant">Montant</label>
                    <input type="number" id="montant" name="montant" class="form-control" required>
                </div>

                <!-- Type de transaction -->
                <div class="form-group mb-4">
                    <label for="type_transaction">Type de transaction</label>
                    <select id="type_transaction" name="type_transaction" class="form-control" required>
                        <option value="credit">Depot d'argent</option>
                        <option value="debit">Retrait d'argent</option>
                    </select>
                </div>

                <!-- Bouton de validation -->
                <button type="submit" class="btn btn-primary btn-block">Valider la Transaction</button>
            </div>
        </form>
    </div>

    @endsection