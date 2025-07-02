<?php

namespace App\Http\Controllers;

use App\Models\Portefeuille;
use App\Models\EvenementPortefeuille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CoursCryptomonnaie; 
use App\Models\Cryptomonnaie;

class PortefeuilleController extends Controller
{
    // Afficher le tableau de bord avec les informations du portefeuille et les événements
    public function showDashboard()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer ou créer un portefeuille pour cet utilisateur
        $portefeuille = $this->getPortefeuille($user);

        // Récupérer les événements associés à l'utilisateur
        $evenements = $this->getEvenements($user);

        // Récupérer tous les cours des cryptomonnaies avec leurs relations
        $coursCryptomonnaies = CoursCryptomonnaie::with('cryptomonnaie')->get();

        // Retourner les données à la vue
        return view('portefeuille.dashboard', compact('user', 'portefeuille', 'evenements', 'coursCryptomonnaies'));
    }

    // Méthode pour récupérer ou créer un portefeuille
    private function getPortefeuille($user)
    {
        return Portefeuille::firstOrCreate(
            ['user_id' => $user->id],
            ['solde' => 0.00] // Valeur par défaut si le portefeuille n'existe pas
        );
    }

    // Méthode pour récupérer les événements du portefeuille de l'utilisateur
    private function getEvenements($user)
    {
        return EvenementPortefeuille::where('user_id', $user->id)->get();
    }
}
