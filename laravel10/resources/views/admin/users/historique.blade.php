@extends('layouts.opp')

@section('title', 'Dashboard')

@section('content')

<div class="main-content">
    <h3>Historique des transactions de {{ $user->name }}</h3>

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
    @endif

    <a href="{{ route('admin.users.index') }}" class="btn btn-warning">Retour</a>
</div>
@endsection