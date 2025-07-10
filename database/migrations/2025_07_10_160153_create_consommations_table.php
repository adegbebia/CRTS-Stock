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
        Schema::create('consommations', function (Blueprint $table) {
            $table->id('consomation_id');
            $table->integer('annee_consommation');
            $table->String('mois');
            $table->integer('trimestre');
            $table->integer('semestre');
            $table->integer('totalAnnuel');
            $table->integer('nombreJourRuptureStock');
            $table->integer('produit_id');
            $table->foreign('produit_id')->references('produit_id')->on('produits')->onDelete('cascade');





            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consommations');
    }
};
