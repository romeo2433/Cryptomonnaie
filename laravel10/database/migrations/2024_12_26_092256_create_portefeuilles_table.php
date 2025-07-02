<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortefeuillesTable extends Migration
{
    /**
     * Exécutez la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portefeuilles', function (Blueprint $table) {
            $table->id(); // Crée un champ 'id' auto-incrémenté
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Référence à l'utilisateur
            $table->decimal('solde', 20, 8)->default(0.0); // Solde en cryptomonnaie
            $table->timestamps(); // Pour la date de création et de mise à jour
        });
    }

    /**
     * Annulez la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portefeuilles');
    }
}
