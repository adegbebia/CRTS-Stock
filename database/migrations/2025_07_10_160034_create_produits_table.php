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
        Schema::create('produits', function (Blueprint $table) {
            $table->id('produit_id');
            $table->string('codeproduit');
            $table->string('libelle');
            $table->string('conditionnement');
            $table->integer('quantitestock');
            $table->integer('stockmax');
            $table->integer('stockmin');
            $table->integer('stocksecurite');
            $table->date('dateperemption');
            $table->string('lot');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
