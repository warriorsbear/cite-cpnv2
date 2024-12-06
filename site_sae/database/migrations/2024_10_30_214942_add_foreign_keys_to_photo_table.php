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
        Schema::table('photo', function (Blueprint $table) {
            $table->foreign(['id_evenement'], 'photo_ibfk_1')->references(['id_evenement'])->on('evenement')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_post'], 'photo_ibfk_2')->references(['id_post'])->on('post')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_utilisateur'], 'photo_ibfk_3')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_utilisateur_1'], 'photo_ibfk_4')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_visionnage'], 'photo_ibfk_5')->references(['id_visionnage'])->on('visionnage')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photo', function (Blueprint $table) {
            $table->dropForeign('photo_ibfk_1');
            $table->dropForeign('photo_ibfk_2');
            $table->dropForeign('photo_ibfk_3');
            $table->dropForeign('photo_ibfk_4');
            $table->dropForeign('photo_ibfk_5');
        });
    }
};
