@extends('layouts.opp')

@section('title', 'Dashboard')

@section('content')
<div class="main-content">
    <h1>Vos notifications</h1>

    @if($notifications->isEmpty())
        <p>Aucune notification.</p>
    @else
        <ul>
            @foreach($notifications as $notification)
                <li>
                    {{ $notification->data['message'] }}
                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('notifications.markAsRead') }}" method="POST">
        @csrf
        <button type="submit">Marquer comme lues</button>
    </form>
</div>