@extends('layouts.app')

@section('title', 'Mon Dashboard')

@section('content')
<h3 class="events-title">Événements associés à votre portefeuille :</h3>

@if ($evenements->isEmpty())
    <p class="no-events">Aucun événement pour le moment.</p>
@else
    <ul class="event-list">
        @foreach ($evenements as $evenement)
            <li class="event-item">
                <span class="event-type">{{ ucfirst($evenement->type_evenement) }}</span> :
                <strong class="event-amount">{{ $evenement->montant }} USD</strong> - Créé le :
                <span class="event-date">{{ \Carbon\Carbon::parse($evenement->created_at)->format('d/m/Y H:i') }}</span>
            </li>
        @endforeach
    </ul>
    <a href="{{ route('portefeuille.dashboard') }}" class="btn btn-warning">OK</a>
@endif
@endsection