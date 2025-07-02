<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvenementsPortefeuilleTable extends Migration
{
    /**
     * Exécuter la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evenements_portefeuille', function (Blueprint $table) {
            $table->id('idEvenements_portefeuille'); // Clé primaire auto-incrémentée
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Clé étrangère vers la table users
            $table->string('type_evenement', 50); // Type d'événement ("depot", "retrait")
            $table->decimal('montant', 20, 8); // Montant en cryptomonnaie ou en monnaie réelle
            $table->string('statut', 20); // Statut de l'événement ("en_attente", "termine")
            $table->timestamp('date_creation')->useCurrent(); // Date de création de l'événement
            $table->timestamps(); // Pour created_at et updated_at
        });
    }

    /**
     * Rétablir la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evenements_portefeuille');
    }
}
