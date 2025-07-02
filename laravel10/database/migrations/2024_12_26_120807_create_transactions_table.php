<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cryptomonnaie_id')->constrained('cryptomonnaies')->onDelete('cascade');
            $table->decimal('quantite', 20, 8); // Quantité de cryptomonnaie achetée
            $table->decimal('montant', 20, 2); // Montant payé
            $table->decimal('prix_achat', 20, 8)->default(0.00000000); // Prix unitaire au moment de l'achat
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
