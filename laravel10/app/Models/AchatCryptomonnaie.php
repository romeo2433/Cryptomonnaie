<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchatCryptomonnaie extends Model
{
    use HasFactory;

    // Nom explicite de la table associée
    protected $table = 'achats_cryptomonnaies';

    // Colonnes pouvant être remplies
    protected $fillable = [
        'user_id',
        'cryptomonnaie_id',
        'quantite',
        'montant_usd',
        'prix_unitaire',
    ];
    public function cryptomonnaie()
{
    return $this->belongsTo(Cryptomonnaie::class, 'cryptomonnaie_id');
}

}
