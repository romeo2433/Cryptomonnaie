<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('historiques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Utilisateur concerné
            $table->string('type_operation'); // Type d'opération (dépôt, retrait, achat, vente)
            $table->unsignedBigInteger('cryptomonnaie_id')->nullable(); // Cryptomonnaie concernée (pour les achats/ventes)
            $table->decimal('quantite', 20, 8)->nullable(); // Quantité de cryptomonnaie (pour les achats/ventes)
            $table->decimal('montant', 20, 2); // Montant de l'opération
            $table->decimal('prix_unitaire', 20, 8)->nullable(); // Prix unitaire (pour les achats/ventes)
            $table->timestamp('date_operation')->useCurrent(); // Date et heure de l'opération
            $table->timestamps();
    
            // Clés étrangères
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cryptomonnaie_id')->references('id')->on('cryptomonnaies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historiques');
    }
};
