<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursCryptomonnaiesTable extends Migration
{
    /**
     * Exécuter la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cours_cryptomonnaies', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->foreignId('cryptomonnaie_id')->constrained('cryptomonnaies')->onDelete('cascade'); // Référence à la table cryptomonnaies
            $table->decimal('prix', 20, 8); // Prix actuel de la cryptomonnaie
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
        Schema::dropIfExists('cours_cryptomonnaies');
    }
}
