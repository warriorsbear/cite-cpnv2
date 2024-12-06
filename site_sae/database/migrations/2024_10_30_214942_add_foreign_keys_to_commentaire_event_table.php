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
        Schema::table('commentaire_event', function (Blueprint $table) {
            $table->foreign(['id_evenement'], 'commentaire_event_ibfk_1')->references(['id_evenement'])->on('evenement')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_utilisateur'], 'commentaire_event_ibfk_2')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commentaire_event', function (Blueprint $table) {
            $table->dropForeign('commentaire_event_ibfk_1');
            $table->dropForeign('commentaire_event_ibfk_2');
        });
    }
};
