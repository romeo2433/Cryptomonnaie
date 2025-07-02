<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Création de la table roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();  // La clé primaire (id)
            $table->string('name', 50)->unique();  // Le nom du rôle (ex : 'admin', 'user')
            $table->text('description')->nullable();  // Description du rôle (optionnelle)
            $table->timestamps();  // Les colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Suppression de la table roles si la migration est annulée
        Schema::dropIfExists('roles');
    }
};
