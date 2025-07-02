<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Cryptomonnaie;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyseController extends Controller
{
    // Affiche le formulaire d'analyse avec la liste des cryptomonnaies
    public function analyseForm()
    {
        $cryptomonnaies = Cryptomonnaie::all();  // Récupérer toutes les cryptomonnaies
        return view('analyse.form', compact('cryptomonnaies'));  // Retourner la vue avec les cryptomonnaies
    }

    // Traite le formulaire et effectue les calculs
    public function calculate(Request $request)
    {
        // Valider les données reçues
        $validated = $request->validate([
            'cryptos' => 'required|array',  // Vérifie qu'on a une liste de cryptomonnaies
            'start_date' => 'required|date',  // La date de début doit être valide
            'end_date' => 'required|date',  // La date de fin doit être valide
        ]);

        // Convertir les dates en objets Carbon
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        // Récupérer les transactions de l'utilisateur filtrées par date et cryptomonnaie
        $transactions = Transaction::whereIn('cryptomonnaie_id', $validated['cryptos'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Si aucune transaction n'est trouvée
        if ($transactions->isEmpty()) {
            return back()->with('error', 'Aucune transaction trouvée pour la période sélectionnée.');
        }

        // Initialiser des tableaux pour les résultats d'achats et de ventes
        $results = [
            'achat' => [],
            'vente' => []
        ];

        // Organiser les transactions par type (achat ou vente)
        foreach ($transactions as $transaction) {
            $cryptoName = $transaction->cryptomonnaie->nom;
            $prixAchat = $transaction->prix_achat;
            $quantite = $transaction->quantite;
            $montant = $transaction->montant;
            $type = $transaction->type; // "achat" ou "vente"

            // Ajouter les données aux bons tableaux en fonction du type
            if (!isset($results[$type][$cryptoName])) {
                $results[$type][$cryptoName] = [
                    'prix_achat' => [],
                    'quantite' => [],
                    'montant' => [],
                ];
            }

            // Remplir les tableaux pour chaque crypto
            $results[$type][$cryptoName]['prix_achat'][] = $prixAchat;
            $results[$type][$cryptoName]['quantite'][] = $quantite;
            $results[$type][$cryptoName]['montant'][] = $montant;
        }

        // Calcul des statistiques : min, max, moyenne, etc., pour chaque type (achat ou vente)
        $analyseResults = [];
        foreach (['achat', 'vente'] as $type) {
            foreach ($results[$type] as $cryptoName => $data) {
                $analyseResults[$type][$cryptoName] = [
                    'prix_achat_max' => max($data['montant']),
                    'prix_achat_min' => min($data['montant']),
                    'prix_achat_moyenne' => array_sum($data['montant']) / count($data['montant']),
                    'total_quantite' => array_sum($data['quantite']),
                    'total_montant' => array_sum($data['montant']),
                ];
            }
        }

        // Afficher les résultats dans la vue
        return view('analyse.result', compact('analyseResults'));
    }

    // Retourne la vue du formulaire avec les cryptomonnaies
    public function showForm()
    {
        $cryptomonnaies = Cryptomonnaie::all();  // Récupérer toutes les cryptomonnaies
        return view('analyse.form', compact('cryptomonnaies'));  // Retourner la vue du formulaire
    }
}
