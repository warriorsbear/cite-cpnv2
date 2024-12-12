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
        Schema::create('photo', function (Blueprint $table) {
            $table->integer('id_photo', true);
            $table->string('nom', 200);
            $table->string('nom_min', 200)->nullable();
            $table->date('date_prise_vue')->nullable();
            $table->date('date_depot')->nullable();
            $table->text('legende')->nullable();
            $table->string('chemin', 200)->nullable();
            $table->string('exif1', 50)->nullable();
            $table->string('exif2', 50)->nullable();
            $table->string('exif3', 50)->nullable();
            $table->string('exif4', 50)->nullable();
            $table->string('exif5', 50)->nullable();
            $table->string('exif6', 50)->nullable();
            $table->integer('id_evenement')->nullable()->index('id_evenement');
            $table->integer('id_post')->nullable()->index('id_post');
            $table->integer('id_utilisateur')->index('id_utilisateur');
            $table->integer('id_utilisateur_1')->nullable()->index('id_utilisateur_1');
            $table->integer('id_visionnage')->nullable()->index('id_visionnage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo');
    }
};
