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
        Schema::table('decrire', function (Blueprint $table) {
            $table->foreign(['id_photo'], 'decrire_ibfk_1')->references(['id_photo'])->on('photo')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_mot_cle'], 'decrire_ibfk_2')->references(['id_mot_cle'])->on('motcle')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('decrire', function (Blueprint $table) {
            $table->dropForeign('decrire_ibfk_1');
            $table->dropForeign('decrire_ibfk_2');
        });
    }
};
