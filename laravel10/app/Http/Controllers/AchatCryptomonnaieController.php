<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoursCryptomonnaie;
use App\Models\Portefeuille;
use App\Models\Cryptomonnaie;
use App\Models\AchatCryptomonnaie;
use App\Models\Transaction;

class AchatCryptomonnaieController extends Controller
{
    public function index()
    {
        // Récupérer toutes les cryptomonnaies et leurs cours
        $cours = CoursCryptomonnaie::with('cryptomonnaie')->get();
        return view('achat.index', compact('cours'));
    }

    public function acheter(Request $request)
{
    // Valider les données du formulaire
    $request->validate([
        'cryptomonnaie_id' => 'required|exists:cours_cryptomonnaies,cryptomonnaie_id',
        'montant' => 'required|numeric|min:0.01',
    ]);

    // Récupérer le cours de la cryptomonnaie choisie
    $cours = CoursCryptomonnaie::where('cryptomonnaie_id', $request->cryptomonnaie_id)->first();

    if (!$cours) {
        return redirect()->back()->with('error', 'Cryptomonnaie introuvable.');
    }

    // Récupérer le portefeuille de l'utilisateur
    $portefeuille = Portefeuille::where('user_id', auth()->id())->first();

    if (!$portefeuille) {
        return redirect()->back()->with('error', 'Portefeuille introuvable.');
    }

    // Vérifier le solde du portefeuille
    if ($request->montant > $portefeuille->solde) {
        return redirect()->back()->with('error', 'Montant supérieur à votre solde.');
    }

    // Calculer la quantité de cryptomonnaie
    $quantite = $request->montant / $cours->prix;

    // Mise à jour du solde du portefeuille
    $portefeuille->solde -= $request->montant;
    $portefeuille->save();

    // Enregistrement de l'achat (ajouter le type 'achat')
    \DB::table('transactions')->insert([
        'user_id' => auth()->id(),
        'cryptomonnaie_id' => $request->cryptomonnaie_id,
        'quantite' => $quantite,
        'montant' => $request->montant,
        'prix_achat' => $cours->prix,
        'type' => 'achat',  // Ajouter le type 'achat'
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Retourner la vue avec les résultats
    return view('achat.resultat', [
        'quantite' => $quantite,
        'montant' => $request->montant,
        'cryptomonnaie' => $cours->cryptomonnaie->nom,
        'solde_restant' => $portefeuille->solde,
    ]);
}


public function listeTransactions()
{
    // Récupérer les transactions d'achats avec les informations des cryptomonnaies
    $achats = Transaction::join('cryptomonnaies', 'transactions.cryptomonnaie_id', '=', 'cryptomonnaies.id')
                        ->select('transactions.user_id', 'cryptomonnaies.nom AS cryptomonnaie_nom', 'transactions.quantite', 'transactions.montant', 'transactions.created_at')
                        ->where('transactions.user_id', auth()->id())  // Récupérer les achats de l'utilisateur authentifié
                        ->where('transactions.type', 'achat')  // Filtrer par type 'achat'
                        ->orderBy('transactions.created_at', 'desc')  // Trier par date d'achat décroissante
                        ->get();

    // Récupérer les transactions de ventes avec les informations des cryptomonnaies
    $ventes = Transaction::join('cryptomonnaies', 'transactions.cryptomonnaie_id', '=', 'cryptomonnaies.id')
                        ->select('transactions.user_id', 'cryptomonnaies.nom AS cryptomonnaie_nom', 'transactions.quantite', 'transactions.montant', 'transactions.created_at')
                        ->where('transactions.user_id', auth()->id())  // Récupérer les ventes de l'utilisateur authentifié
                        ->where('transactions.type', 'vente')  // Filtrer par type 'vente'
                        ->orderBy('transactions.created_at', 'desc')  // Trier par date de vente décroissante
                        ->get();

    // Passer les achats et ventes à la vue
    return view('transactions.liste', compact('achats', 'ventes'));
}



    public function totalAchatParCryptomonnaie()
    {
        // Récupérer la somme de la quantité et du montant par cryptomonnaie_id, pour l'utilisateur connecté
        $totaux = Transaction::where('user_id', auth()->id())  // Filtrer par l'utilisateur connecté
                             ->select('cryptomonnaie_id', 
                                      \DB::raw('SUM(quantite) AS total_quantite'),
                                      \DB::raw('SUM(montant) AS total_montant'))
                             ->groupBy('cryptomonnaie_id')
                             ->get();
    
        // Retourner les résultats à la vue
        return view('achat.total', compact('totaux'));
    }

   
       
}
