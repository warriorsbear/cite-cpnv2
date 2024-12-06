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
        Schema::create('participation', function (Blueprint $table) {
            $table->integer('id_utilisateur');
            $table->integer('id_evenement')->index('id_evenement');
            $table->boolean('presence')->nullable();

            $table->primary(['id_utilisateur', 'id_evenement']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Participation');
    }
};
