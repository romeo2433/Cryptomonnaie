<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AchatCryptomonnaie;
use App\Models\CoursCryptomonnaie;
use App\Models\Portefeuille;

class VenteCryptomonnaieController extends Controller
{
    public function index()
    {
        // Récupérer les cryptomonnaies achetées par l'utilisateur
        $achats = AchatCryptomonnaie::where('user_id', auth()->id())
            ->with('cryptomonnaie')
            ->get();

        return view('vente.index', compact('achats'));
    }

    public function vendre(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'cryptomonnaie_id' => 'required|exists:achats_cryptomonnaies,cryptomonnaie_id',
            'quantite' => 'required|numeric|min:0.00000001',
        ]);

        // Trouver l'achat de la cryptomonnaie
        $achat = AchatCryptomonnaie::where('user_id', auth()->id())
            ->where('cryptomonnaie_id', $request->cryptomonnaie_id)
            ->first();

        if (!$achat) {
            return redirect()->back()->with('error', 'Achat introuvable.');
        }

        // Vérifier que l'utilisateur a assez de quantité pour vendre
        if ($request->quantite > $achat->quantite) {
            return redirect()->back()->with('error', 'Quantité insuffisante.');
        }

        // Récupérer le cours actuel de la cryptomonnaie
        $cours = CoursCryptomonnaie::where('cryptomonnaie_id', $request->cryptomonnaie_id)->first();

        if (!$cours) {
            return redirect()->back()->with('error', 'Cours de la cryptomonnaie introuvable.');
        }

        // Calculer le montant en USD pour la vente
        $montant_usd = $request->quantite * $cours->prix;

        // Mettre à jour la quantité restante dans l'achat
        $achat->quantite -= $request->quantite;
        $achat->save();

        // Ajouter le montant au solde du portefeuille de l'utilisateur
        $portefeuille = Portefeuille::where('user_id', auth()->id())->first();

        if (!$portefeuille) {
            return redirect()->back()->with('error', 'Portefeuille introuvable.');
        }

        $portefeuille->solde += $montant_usd;
        $portefeuille->save();

        // Retourner un résultat de vente
        return view('vente.resultat', [
            'quantite_vendue' => $request->quantite,
            'montant' => $montant_usd,
            'cryptomonnaie' => $cours->cryptomonnaie->nom,
            'solde_restant' => $portefeuille->solde,
        ]);
    }
}
