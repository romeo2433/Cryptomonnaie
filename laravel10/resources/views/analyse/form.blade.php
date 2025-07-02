@extends('layouts.app')

@section('title', 'Mon Dashboard')

@section('content')

<form action="{{ route('analyse.calculate') }}" method="POST">
    @csrf
    <label for="cryptos">Sélectionner des cryptomonnaies :</label><br>

    @foreach($cryptomonnaies as $crypto)
        <input type="checkbox" name="cryptos[]" value="{{ $crypto->id }}" id="crypto{{ $crypto->id }}">
        <label for="crypto{{ $crypto->id }}">{{ $crypto->nom }}</label><br>
    @endforeach

    <br>

    <label for="start_date">Date de début :</label>
    <input type="datetime-local" name="start_date" required>
    <br>

    <label for="end_date">Date de fin :</label>
    <input type="datetime-local" name="end_date" required>
    <br>

    <button type="submit">Valider</button>
</form>
@endsection
