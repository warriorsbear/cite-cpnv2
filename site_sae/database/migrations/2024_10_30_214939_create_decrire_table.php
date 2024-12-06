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
        Schema::create('decrire', function (Blueprint $table) {
            $table->integer('id_photo');
            $table->integer('id_mot_cle')->index('id_mot_cle');

            $table->primary(['id_photo', 'id_mot_cle']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decrire');
    }
};
