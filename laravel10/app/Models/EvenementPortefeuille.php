<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EvenementPortefeuille extends Model
{
    use HasFactory;

    // Nom de la table
    protected $table = 'evenements_portefeuille';

    // Clé primaire
    protected $primaryKey = 'idEvenements_portefeuille';

    // Champs assignables en masse
    protected $fillable = [
        'user_id',
        'type_evenement',
        'montant',
        'statut',
        'date_creation', // Si vous utilisez ce champ
    ];

    // Champs de date (pour Carbon)
    protected $dates = [
        'date_creation', // Si vous utilisez ce champ
        'created_at',    // Ajoutez les timestamps si nécessaire
        'updated_at',    // Ajoutez les timestamps si nécessaire
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Méthode pour afficher les événements (à déplacer dans un contrôleur)
    public static function showEvenement()
    {
        return EvenementPortefeuille::where('user_id', auth()->id())->get();
    }

    // Accessor pour formater la date de création
    public function getDateCreationAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y H:i:s'); // Format personnalisé
    }

    // Mutator pour définir la date de création
    public function setDateCreationAttribute($value)
    {
        $this->attributes['date_creation'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    // Méthode pour vérifier si une transaction est en attente
    public function isEnAttente()
    {
        return $this->statut === 'en_attente';
    }

    // Méthode pour vérifier si une transaction est validée
    public function isValide()
    {
        return $this->statut === 'valide';
    }

    // Méthode pour vérifier si une transaction est rejetée
    public function isRejete()
    {
        return $this->statut === 'rejete';
    }
}