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
        Schema::table('evenement', function (Blueprint $table) {
            $table->foreign(['id_utilisateur'], 'evenement_ibfk_1')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evenement', function (Blueprint $table) {
            $table->dropForeign('evenement_ibfk_1');
        });
    }
};
