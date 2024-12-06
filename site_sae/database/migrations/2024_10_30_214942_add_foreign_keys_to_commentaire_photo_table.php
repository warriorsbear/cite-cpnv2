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
        Schema::table('commentaire_photo', function (Blueprint $table) {
            $table->foreign(['id_utilisateur'], 'commentaire_photo_ibfk_1')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_photo'], 'commentaire_photo_ibfk_2')->references(['id_photo'])->on('photo')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commentaire_photo', function (Blueprint $table) {
            $table->dropForeign('commentaire_photo_ibfk_1');
            $table->dropForeign('commentaire_photo_ibfk_2');
        });
    }
};
