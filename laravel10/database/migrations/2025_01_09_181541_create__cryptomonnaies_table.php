<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptomonnaiesTable extends Migration
{
    /**
     * Exécuter la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cryptomonnaies', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->string('nom', 100); // Nom de la cryptomonnaie
            $table->string('symbole', 10)->unique(); // Symbole unique
            $table->text('description')->nullable(); // Description facultative
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
        Schema::dropIfExists('cryptomonnaies');
    }
}
