<!doctype html>
<html lang="fr">
<head>
    <title>connection des utilisateurs</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    
    <style>body{padding-top: 60px;}</style>

    <link href="assets/css2/bootstrap.css" rel="stylesheet" />
    <link href="assets/css2/login-register.css" rel="stylesheet" />
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

    <script src="assets/js2/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="assets/js2/bootstrap.js" type="text/javascript"></script>
    <script src="assets/js2/login-register.js" type="text/javascript"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <a class="btn big-login" data-toggle="modal" href="javascript:void(0)" onclick="openLoginModal();">Log in</a>
                
            </div>
            <div class="col-sm-4"></div>
        </div>

        <div class="modal fade login" id="loginModal">
            <div class="modal-dialog login animated">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Connexion</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box">
                            <div class="content">
                                <div class="social">
                                    <a class="circle github" href="#"><i class="fa fa-github fa-fw"></i></a>
                                    <a id="google_login" class="circle google" href="#"><i class="fa fa-google-plus fa-fw"></i></a>
                                    <a id="facebook_login" class="circle facebook" href="#"><i class="fa fa-facebook fa-fw"></i></a>
                                </div>
                                <div class="division">
                                    <div class="line l"></div>
                                    <span>ou</span>
                                    <div class="line r"></div>
                                </div>

                                <!-- Messages de session -->
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @elseif(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <!-- Formulaire de connexion Laravel -->
                                <div class="form loginBox">
                                    <form method="POST" action="{{ url('login') }}" accept-charset="UTF-8">
                                        @csrf
                                        <input id="email" class="form-control" type="email" placeholder="Adresse email" name="email" required>
                                        <input id="password" class="form-control" type="password" placeholder="Mot de passe" name="password" required>
                                        <button type="submit" class="btn btn-primary btn-login">Se connecter</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <div class="forgot login-footer">
                            <span>Vous n'avez pas encore de compte ? <a href="inscription">Créer un compte</a></span>
                        </div>
                        <div class="forgot register-footer" style="display:none">
                            <span>Vous avez déjà un compte ?</span>
                            <a href="javascript: showLoginForm();">Se connecter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            openLoginModal();
        });
    </script>

</body>
</html>
