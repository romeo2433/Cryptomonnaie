<?php

namespace App\Http\Controllers;

use App\Models\EvenementPortefeuille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Portefeuille;
use App\Models\CoursCryptomonnaie; 
use App\Models\Cryptomonnaie; 
use App\Notifications\TransactionStatusNotification;
use App\Models\User; 

class EvenementPortefeuilleController extends Controller
{
    public function showEvenement()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
    
        // Récupérer ou créer un portefeuille pour cet utilisateur
        $portefeuille = Portefeuille::firstOrCreate(
            ['user_id' => $user->id],
            ['solde' => 0.00] // Valeur par défaut si le portefeuille n'existe pas
        );
    
        // Récupérer les événements associés à l'utilisateur
        $evenements = EvenementPortefeuille::where('user_id', $user->id)->get();
    
        // Retourner la vue avec les événements
        return view('portefeuille.evenement', compact('user', 'portefeuille', 'evenements'));
    }
    
    
    public function showForm()
    {
        // Récupère l'utilisateur connecté
        $user = Auth::user();
    
        // Récupérer ou créer un portefeuille pour cet utilisateur
        $portefeuille = Portefeuille::firstOrCreate(
            ['user_id' => $user->id],
            ['solde' => 0.00]
        );
    
        // Retourner la vue avec le formulaire de création d'événement
        return view('evenement.create', compact('user', 'portefeuille'));
    }
    public function store(Request $request)
{
    // Validation des données
    $request->validate([
        'montant' => 'required|numeric|min:0',
        'type_transaction' => 'required|in:credit,debit',
    ]);

    // Récupérer l'utilisateur connecté
    $user = Auth::user();

    // Récupérer ou créer un portefeuille pour cet utilisateur
    $portefeuille = Portefeuille::firstOrCreate(
        ['user_id' => $user->id],
        ['solde' => 0.00] // Valeur par défaut si le portefeuille n'existe pas
    );

    // Vérifier si c'est un retrait et si le solde est suffisant
    if ($request->type_transaction == 'debit' && $portefeuille->solde < $request->montant) {
        return back()->with('error', 'Solde insuffisant pour effectuer le retrait');
    }

    // Créer l'événement lié à la transaction avec le statut "en_attente"
    EvenementPortefeuille::create([
        'user_id' => $user->id,
        'type_evenement' => $request->type_transaction == 'credit' ? 'depot' : 'retrait',
        'montant' => $request->montant,
        'statut' => 'en_attente', // Statut par défaut
    ]);

    // Retourner la vue avec un message de succès
    return redirect()->route('portefeuille.evenement')->with('success', 'Transaction en attente de validation par l\'admin.');
}

public function showTransactionsEnAttente()
{
    // Récupérer toutes les transactions en attente
    $transactions = EvenementPortefeuille::where('statut', 'en_attente')->get();

    // Retourner la vue avec les transactions
    return view('admin.transactions', compact('transactions'));
}
public function validerTransaction(Request $request, $id)
{
    // Récupérer la transaction
    $transaction = EvenementPortefeuille::findOrFail($id);

    // Valider ou rejeter la transaction
    if ($request->action == 'valider') {
        $transaction->statut = 'valide';

        // Mettre à jour le solde du portefeuille
        $portefeuille = Portefeuille::where('user_id', $transaction->user_id)->first();
        if ($transaction->type_evenement == 'depot') {
            $portefeuille->solde += $transaction->montant;
        } else {
            $portefeuille->solde -= $transaction->montant;
        }
        $portefeuille->save();
    } else {
        $transaction->statut = 'rejete';
    }

    // Sauvegarder la transaction
    $transaction->save();

    // Envoyer une notification à l'utilisateur
    $transaction->user->notify(new TransactionStatusNotification($transaction));

    // Rediriger avec un message de succès
    return redirect()->route('admin.transactions')->with('success', 'Transaction traitée avec succès.');
}

public function historiqueParUtilisateur($userId)
{
    // Récupérer l'utilisateur
    $user = User::findOrFail($userId);

    // Récupérer les transactions de cet utilisateur
    $evenements = EvenementPortefeuille::where('user_id', $userId)
                                        ->orderBy('created_at', 'desc')
                                        ->get();

    // Retourner la vue avec les événements
    return view('admin.users.historique', compact('user', 'evenements'));
}



}
