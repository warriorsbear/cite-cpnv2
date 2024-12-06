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
        Schema::table('document', function (Blueprint $table) {
            $table->foreign(['id_evenement'], 'document_ibfk_1')->references(['id_evenement'])->on('evenement')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_utilisateur'], 'document_ibfk_2')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document', function (Blueprint $table) {
            $table->dropForeign('document_ibfk_1');
            $table->dropForeign('document_ibfk_2');
        });
    }
};
