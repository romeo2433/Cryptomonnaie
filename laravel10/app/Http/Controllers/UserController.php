<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserModel;

class UserController extends Controller
{
    // Méthode pour récupérer tous les utilisateurs
    public function index()
    {
        $users = UserModel::getAllUsers();  // Utilisation de la méthode du modèle

        // Retourner la réponse en JSON
        return response()->json($users);
    }

    // Méthode pour récupérer un utilisateur par ID
    public function show($id)
    {
        $user = UserModel::getUserById($id);  // Utilisation de la méthode du modèle

        // Si l'utilisateur est trouvé, retourner en JSON, sinon message d'erreur
        if ($user) {
            return response()->json($user);
        }

        return response()->json(['message' => 'Utilisateur non trouvé'], 404);
    }
     // Méthode pour insérer un utilisateur
     public function store(Request $request)
     {
         try {
             $request->validate([
                 'name' => 'required|string|max:255',
                 'email' => 'required|email|unique:users,email',
                 'password' => 'required|string|min:6'
             ]);
     
             $name = $request->input('name');
             $email = $request->input('email');
             $password = $request->input('password');
     
             $inserted = UserModel::insertUser($name, $email, $password);
     
             if ($inserted) {
                 return response()->json(['message' => 'Utilisateur créé avec succès'], 201);
             }
     
             return response()->json(['message' => 'Erreur lors de l\'insertion de l\'utilisateur'], 500);
         } catch (\Exception $e) {
             return response()->json(['error' => $e->getMessage()], 500);
         }
     }
     
}
