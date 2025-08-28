<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    @include('layouts.header')

    <div class="dashboard-container">
        @include('layouts.sidebar2')

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    @include('layouts.footer')
    <style>
        table {
            width: 100%;
            border-collapse: collapse; /* enlève les espaces entre les cellules */
            margin: 20px 0;
            font-size: 16px;
            text-align: left;
            }

        th, td {
            border: 1px solid #ddd;   /* bordures fines */
            padding: 12px 15px;       /* espace intérieur */
            }

        tr:nth-child(even) {
            background-color: #f9f9f9; /* alternance de couleur */
            }

        tr:hover {
            background-color: #f1f1f1; /* survol */
            }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            }
        p {
            margin-bottom: 15px;
            color: #555;
            }

    </style>
</body>
</html>