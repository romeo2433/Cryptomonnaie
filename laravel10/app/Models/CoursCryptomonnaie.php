<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursCryptomonnaie extends Model
{
    use HasFactory;

    // Définissez les colonnes qui peuvent être assignées en masse
    protected $fillable = ['cryptomonnaie_id', 'prix', 'updated_at'];

    /**
     * Relation avec le modèle Cryptomonnaie.
     * Une entrée de cours appartient à une cryptomonnaie.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cryptomonnaie()
    {
        return $this->belongsTo(Cryptomonnaie::class);
    }
}
