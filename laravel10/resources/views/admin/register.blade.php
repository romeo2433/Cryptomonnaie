<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Admin</title>

    <!-- Bootstrap CSS -->
   
    <link href=" {{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assetsassets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Inscription Admin</h5>
                                        <p class="text-center small">Créez un compte administrateur</p>
                                    </div>
                                    
                                    @if(session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form class="row g-3 needs-validation" action="{{ route('admin.register.submit') }}" method="POST" novalidate>
                                        @csrf
                                        <div class="col-12">
                                            <label for="name" class="form-label">Nom</label>
                                            <input type="text" name="name" class="form-control" id="name" required>
                                            <div class="invalid-feedback">Veuillez entrer votre nom !</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" id="email" required>
                                            <div class="invalid-feedback">Veuillez entrer une adresse email valide !</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">Mot de passe</label>
                                            <input type="password" name="password" class="form-control" id="password" required>
                                            <div class="invalid-feedback">Veuillez entrer un mot de passe !</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                                            <div class="invalid-feedback">Veuillez confirmer votre mot de passe !</div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">S'inscrire</button>
                                        </div>

                                        <div class="col-12">
                                            <p class="small mb-0">Déjà un compte ? <a href="{{ route('admin.login') }}">Connectez-vous</a></p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
