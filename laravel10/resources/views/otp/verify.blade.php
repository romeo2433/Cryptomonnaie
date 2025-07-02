<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification OTP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #007bff;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            text-align: center;
            font-size: 20px;
            letter-spacing: 4px;
        }

        .btn-primary {
            width: 100%;
            background-color: #007bff;
            border: none;
            padding: 10px;
            font-size: 16px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Vérification de l'OTP</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulaire pour saisir l'OTP -->
        <form action="{{ route('otp.verify.submit') }}" method="POST">
            @csrf
            <div class="form-group mt-3">
                <label for="otp">Entrez le code OTP reçu par email</label>
                <input type="text" class="form-control text-center" name="otp" id="otp" required maxlength="6">
            </div>
            <button type="submit" class="btn btn-primary mt-4">Vérifier</button>
        </form>
    </div>

</body>
</html>
