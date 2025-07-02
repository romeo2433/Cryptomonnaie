<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'otp',
        'date_debut',
        'date_expiration',
    ];

    // Si vous ne voulez pas que les dates 'created_at' et 'updated_at' soient gérées automatiquement
    // par Laravel, vous pouvez les désactiver ici.
    public $timestamps = true;
}
