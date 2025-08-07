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
        Schema::create('mouvement_produits', function (Blueprint $table) {
            $table->id('mouvementProd_id');
            $table->integer('produit_id');
            // $table->integer('user_id')->nullable()->after('produit_id');
            $table->date('date');
            $table->string('origine')->nullable(); 
            $table->integer('quantite_commandee')->nullable();
            $table->integer('quantite_entree')->nullable();
            $table->integer('quantite_sortie')->nullable();
            // $table->integer('stock_debut_mois');
            $table->integer('avarie')->nullable(); 
            $table->integer('stock_jour');
            $table->text('observation')->nullable(); 
            $table->foreign('produit_id')->references('produit_id')->on('produits')->onDelete('cascade');
            // $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

            $table->timestamps();
        
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mouvement_produits');
    }
};
