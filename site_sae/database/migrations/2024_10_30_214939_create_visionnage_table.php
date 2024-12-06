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
        Schema::create('visionnage', function (Blueprint $table) {
            $table->integer('id_visionnage', true);
            $table->dateTime('date_visibilite')->nullable();
            $table->dateTime('date_diffusion')->nullable();
            $table->integer('id_evenement')->unique('id_evenement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visionnage');
    }
};
