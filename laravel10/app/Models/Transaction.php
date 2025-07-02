<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions'; // Spécifier la table si le nom de la table ne suit pas la convention
    protected $fillable = ['user_id', 'cryptomonnaie_id', 'quantite', 'montant', 'prix_achat', 'type'];

    // Si vous avez une relation avec le modèle Cryptomonnaie
    public function cryptomonnaie()
    {
        return $this->belongsTo(Cryptomonnaie::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
