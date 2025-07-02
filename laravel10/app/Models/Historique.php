<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'historiques';

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type_operation',
        'cryptomonnaie_id',
        'quantite',
        'montant',
        'prix_unitaire',
        'date_operation',
    ];

    /**
     * Les attributs qui doivent être convertis en types natifs.
     *
     * @var array
     */
    protected $casts = [
        'date_operation' => 'datetime',
        'quantite' => 'decimal:8',
        'montant' => 'decimal:2',
        'prix_unitaire' => 'decimal:8',
    ];

    /**
     * Relation avec l'utilisateur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec la cryptomonnaie.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cryptomonnaie()
    {
        return $this->belongsTo(Cryptomonnaie::class);
    }
}