<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portefeuille;
use Illuminate\Support\Facades\Auth;
use App\Models\Cryptomonnaie; 
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;


class TransactionController extends Controller
{
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'montant' => 'required|numeric',
            'type_transaction' => 'required|in:credit,debit',
        ]);

        // Récupération de l'utilisateur authentifié
        $user = Auth::user();

        // Récupération du portefeuille de l'utilisateur
        $portefeuille = Portefeuille::where('user_id', $user->id)->first();

        if (!$portefeuille) {
            return redirect()->back()->withErrors(['message' => 'Portefeuille non trouvé.']);
        }

        // Calcul du nouveau solde en fonction du type de transaction
        if ($request->type_transaction == 'credit') {
            $portefeuille->solde += $request->montant; // Ajout du montant au solde
        } elseif ($request->type_transaction == 'debit') {
            if ($portefeuille->solde < $request->montant) {
                return redirect()->back()->withErrors(['message' => 'Solde insuffisant pour effectuer cette transaction.']);
            }
            $portefeuille->solde -= $request->montant; // Soustraction du montant du solde
        }

        // Mise à jour du portefeuille
        $portefeuille->save();

        return redirect()->route('portefeuille.dashboard')->with('success', 'Transaction effectuée avec succès!');
    }

    public function create()
    {
        // Récupérer toutes les cryptomonnaies disponibles pour la vente
        $cryptomonnaies = Cryptomonnaie::all();

        // Retourner la vue avec les données
        return view('vente.create', compact('cryptomonnaies'));
    }


    public function effectuerVente(Request $request)
    {
        // Validation des données soumises
        $request->validate([
            'cryptomonnaie_id' => 'required|exists:cryptomonnaies,id',
            'quantite' => 'required|numeric|min:0.00000001',
        ]);
    
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
    
        // Récupérer les transactions existantes pour cette cryptomonnaie
        $totalQuantite = Transaction::where('user_id', $user->id)
            ->where('cryptomonnaie_id', $request->cryptomonnaie_id)
            ->sum('quantite');
    
        // Vérifier si l'utilisateur a assez de cryptomonnaie pour vendre
        if ($request->quantite > $totalQuantite) {
            return redirect()->back()->withErrors(['message' => 'Quantité insuffisante pour effectuer la vente.']);
        }
    
        // Récupérer le prix actuel de la cryptomonnaie depuis la table cours_cryptomonnaies
        $prixUnitaire = DB::table('cours_cryptomonnaies')
            ->where('cryptomonnaie_id', $request->cryptomonnaie_id)
            ->value('prix'); // Récupère le prix de la cryptomonnaie
    
        // Vérifier si le prix a bien été récupéré
        if (!$prixUnitaire) {
            return redirect()->back()->withErrors(['message' => 'Prix actuel non disponible pour cette cryptomonnaie.']);
        }

        // Calculer le montant de la vente (prix unitaire de la cryptomonnaie)
        $montantVente = $request->quantite * $prixUnitaire; // Montant de la vente
    
        // Vérifier si le montant de la vente est bien calculé
        if (!$montantVente) {
            return redirect()->back()->withErrors(['message' => 'Erreur dans le calcul du montant de la vente.']);
        }
    
        // Créer une transaction négative (débit de cryptomonnaie) et ajouter le type 'vente'
        Transaction::create([
            'user_id' => $user->id,
            'cryptomonnaie_id' => $request->cryptomonnaie_id,
            'quantite' => -1 * $request->quantite, // Quantité négative pour la vente
            'montant' => $montantVente, // Montant calculé de la vente
            'prix_achat' => $prixUnitaire, // Prix au moment de la vente
            'type' => 'vente', // Type de transaction
        ]);
    
        // Ajouter le montant de la vente au portefeuille de l'utilisateur
        $portefeuille = Portefeuille::where('user_id', $user->id)->first();
        $portefeuille->solde += $montantVente;
        $portefeuille->save();
    
        return redirect()->route('portefeuille.dashboard')->with('success', 'Vente effectuée avec succès !');
    }
    public function index(Request $request)
    {
        // Récupérer les paramètres de filtre
        $userId = $request->query('user_id');
        $cryptomonnaieId = $request->query('cryptomonnaie_id');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Filtrer les transactions
        $transactions = Transaction::with(['user', 'cryptomonnaie'])
            ->when($userId, function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->when($cryptomonnaieId, function ($query, $cryptomonnaieId) {
                return $query->where('cryptomonnaie_id', $cryptomonnaieId);
            })
            ->when($startDate, function ($query, $startDate) {
                return $query->where('created_at', '>=', Carbon::parse($startDate)->startOfDay());
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay());
            })
            ->get();

        // Récupérer tous les utilisateurs et cryptomonnaies pour les filtres
        $users = User::all();
        $cryptomonnaies = Cryptomonnaie::all();

        return view('transactions.index', compact('transactions', 'users', 'cryptomonnaies'));
    }
    

        

    
}
