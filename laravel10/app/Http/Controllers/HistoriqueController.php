<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historique;

class HistoriqueController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer les dates de filtrage
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Requête de base avec l'utilisateur connecté
        $query = Historique::where('user_id', auth()->id())
            ->with(['user', 'cryptomonnaie'])
            ->orderBy('date_operation', 'desc');

        // Appliquer le filtre si les dates sont fournies
        if ($startDate && $endDate) {
            $query->whereBetween('date_operation', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        // Paginer les résultats
        $historiques = $query->paginate(10);

        return view('historique.index', compact('historiques', 'startDate', 'endDate'));
    }
}
