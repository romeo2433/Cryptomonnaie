<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Traiter la soumission du formulaire de connexion
    public function login(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Tenter de connecter l'utilisateur
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Si la connexion réussit, rediriger vers le tableau de bord
            return redirect()->intended('/admin/transactions');
        }

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->intended('/admin/transactions');
        }

        // Si la connexion échoue, rediriger avec un message d'erreur
        return back()->withErrors([
            'email' => 'Les informations d\'identification ne correspondent pas.',
        ]);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}