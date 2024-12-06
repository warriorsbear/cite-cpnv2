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
        Schema::create('evenement', function (Blueprint $table) {
            $table->integer('id_evenement', true);
            $table->dateTime('date_heure')->nullable();
            $table->string('titre', 50)->nullable();
            $table->text('descriptif')->nullable();
            $table->string('lieu', 50)->nullable();
            $table->string('type', 50)->nullable();
            $table->boolean('officiel')->nullable();
            $table->integer('id_utilisateur')->nullable()->index('id_utilisateur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evenement');
    }
};
