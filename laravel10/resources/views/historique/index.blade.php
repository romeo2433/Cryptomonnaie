<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des opérations</title>
    <style>
        .filter-form {
            margin-bottom: 20px;
        }
        .filter-form input {
            margin-right: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Historique des opérations</h1>

    <!-- Formulaire de filtrage par date -->
    <form action="{{ route('historique.index') }}" method="GET" class="filter-form">
        <label for="start_date">Date de début :</label>
        <input type="date" id="start_date" name="start_date" value="{{ $startDate }}">

        <label for="end_date">Date de fin :</label>
        <input type="date" id="end_date" name="end_date" value="{{ $endDate }}">

        <button type="submit">Filtrer</button>
    </form>

    <!-- Tableau des opérations -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Type</th>
                <th>Cryptomonnaie</th>
                <th>Quantité</th>
                <th>Montant</th>
                <th>Prix unitaire</th>
                <th>Date et heure</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historiques as $historique)
                <tr>
                    <td>{{ $historique->id }}</td>
                    <td>{{ $historique->user->name }}</td>
                    <td>{{ ucfirst($historique->type_operation) }}</td>
                    <td>{{ $historique->cryptomonnaie ? $historique->cryptomonnaie->nom : 'N/A' }}</td>
                    <td>{{ $historique->quantite ?? 'N/A' }}</td>
                    <td>{{ $historique->montant }}</td>
                    <td>{{ $historique->prix_unitaire ?? 'N/A' }}</td>
                    <td>{{ $historique->date_operation->format('d/m/Y H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $historiques->links() }}
</body>
</html>