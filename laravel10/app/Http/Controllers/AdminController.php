<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Afficher le formulaire d'inscription
    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    // Traiter la soumission du formulaire
    public function register(Request $request)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Création de l'admin
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirection avec un message de succès
        return redirect()->route('admin.register')->with('success', 'Inscription réussie !');
    }

    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::with('transactions.cryptomonnaie')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
    public function updateAvatar(Request $request, User $user)
{
    $request->validate([
        'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    if ($request->hasFile('avatar')) {
        if($user->avatar && Storage::disk('public')->exists($user->avatar)){
            Storage::disk('public')->delete($user->avatar);
        }
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $avatarPath;
        $user->save();
    }

    return back()->with('success', 'Avatar mis à jour avec succès.');
}

}