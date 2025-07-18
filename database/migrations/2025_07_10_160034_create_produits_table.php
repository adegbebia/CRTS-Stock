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
            $table->id('produit_id')->unique();
            $table->string('codeproduit');
            $table->string('libelle')->unique();
            $table->string('conditionnement');
            $table->integer('quantitestock');
            $table->integer('stockmax');
            $table->integer('stockmin');
            $table->integer('stocksecurite');
            $table->date('dateperemption');
            $table->string('lot')->unique();
            $table->integer('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->OnDelete('cascade');
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
