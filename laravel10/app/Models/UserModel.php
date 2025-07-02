<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // Importer DB pour Query Builder

class UserModel extends Model
{
    // Indiquer la table associée
    protected $table = 'users';

    // Méthode pour récupérer tous les utilisateurs
    public static function getAllUsers()
    {
        return DB::table('users')->get();
    }

    // Méthode pour récupérer un utilisateur par ID
    public static function getUserById($id)
    {
        return DB::table('users')->where('id', $id)->first();
    }



    
    // Méthode pour insérer un utilisateur
    public static function insertUser($name, $email, $password)
    {
        return DB::table('users')->insert([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password), // Hasher le mot de passe
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
