<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cryptomonnaie extends Model
{
    use HasFactory;

    // Définissez les colonnes qui peuvent être assignées en masse
    protected $fillable = ['nom', 'symbole', 'description'];

    /**
     * Relation avec le modèle CoursCryptomonnaie.
     * Une cryptomonnaie peut avoir plusieurs cours.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cours()
    {
        return $this->hasMany(CoursCryptomonnaie::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
