<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class UserVueController extends Controller
{
    // Méthode pour afficher la vue d'inscription
    public function index()
    {
        return view('connection.inscription');
    }

    // Méthode pour insérer un utilisateur dans la base de données
    // Exemple de code pour l'inscription
public function store(Request $request)
{
    $name = $request->input('name');
    $email = $request->input('email');
    $password = $request->input('password'); // Assurez-vous que le mot de passe est bien haché

    $inserted = UserModel::insertUser($name, $email, $password); // Insère l'utilisateur avec le mot de passe haché

    if ($inserted) {
        return redirect()->route('login')->with('success', 'Utilisateur créé avec succès');
    }

    return redirect()->route('inscription')->with('error', 'Erreur lors de l\'insertion de l\'utilisateur');
}

}
