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
        Schema::create('commentaire_event', function (Blueprint $table) {
            $table->integer('id_commentaire_e', true);
            $table->text('texte')->nullable();
            $table->dateTime('date_heure')->nullable();
            $table->integer('id_evenement')->index('id_evenement');
            $table->integer('id_utilisateur')->index('id_utilisateur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commentaire_event');
    }
};
