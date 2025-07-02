@extends('layouts.opp')

@section('title', 'Dashboard')

@section('content')
    <h1>Transactions en attente</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if($transactions->isEmpty())
        <p>Aucune transaction en attente.</p>
    @else
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Utilisateur</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->idEvenements_portefeuille }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ $transaction->type_evenement }}</td>
                        <td>{{ $transaction->montant }}</td>
                        <td>{{ $transaction->statut }}</td>
                        <td>
                        <form action="{{ route('admin.valider.transaction', $transaction->idEvenements_portefeuille) }}" method="POST">

                                @csrf
                                <button type="submit" name="action" value="valider">Valider</button>
                                <button type="submit" name="action" value="rejeter">Rejeter</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>