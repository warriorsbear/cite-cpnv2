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
        Schema::create('utilisateur', function (Blueprint $table) {
            $table->integer('id_utilisateur', true);
            $table->string('pseudo', 50)->nullable();
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->string('adresse', 100)->nullable();
            $table->char('cp', 5)->nullable();
            $table->string('ville', 50)->nullable();
            $table->char('telephone', 20)->nullable();
            $table->string('mail', 50)->unique('mail');
            $table->string('mdp', 250);
            $table->string('role', 50)->nullable();
            $table->boolean('statut')->nullable();
            $table->boolean('notif_mail')->nullable();
            $table->boolean('statut_cotisation')->nullable();
            $table->string('photo_de_profile', 250)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateur');
    }
};
