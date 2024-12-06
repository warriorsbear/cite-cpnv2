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
        Schema::table('Participation', function (Blueprint $table) {
            $table->foreign(['id_utilisateur'], 'participation_ibfk_1')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_evenement'], 'participation_ibfk_2')->references(['id_evenement'])->on('evenement')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Participation', function (Blueprint $table) {
            $table->dropForeign('participation_ibfk_1');
            $table->dropForeign('participation_ibfk_2');
        });
    }
};
