<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portefeuille extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'solde'];
    protected $dates = ['created_at', 'updated_at']; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
