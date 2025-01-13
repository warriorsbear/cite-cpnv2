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
        Schema::create('document', function (Blueprint $table) {
            $table->integer('id_document', true);
            $table->string('nom', 50)->nullable();
            $table->string('chemin')->nullable();
            $table->timestamps();
            $table->integer('id_evenement')->nullable()->index('id_evenement');
            $table->integer('id_utilisateur')->index('id_utilisateur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document');
    }
};
